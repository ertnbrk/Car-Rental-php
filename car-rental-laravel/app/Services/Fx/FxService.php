<?php

namespace App\Services\Fx;

use App\Models\FxRate;
use Carbon\Carbon;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use SimpleXMLElement;

/**
 * Service for fetching and managing foreign exchange rates.
 */
class FxService
{
    private const CACHE_KEY = 'fx:latest';
    private const CACHE_TTL = 3600; // 1 hour

    /**
     * Fetch latest rates from TCMB (Turkish Central Bank).
     *
     * @return array|null Array of rates or null on failure
     */
    public function fetchFromTCMB(): ?array
    {
        try {
            $url = config('fx.tcmb_url', 'https://www.tcmb.gov.tr/kurlar/today.xml');
            $response = Http::timeout(10)->get($url);

            if (!$response->successful()) {
                Log::error('Failed to fetch FX rates from TCMB', [
                    'status' => $response->status(),
                ]);
                return null;
            }

            return $this->parseTCMBXml($response->body());
        } catch (\Exception $e) {
            Log::error('Error fetching FX rates from TCMB', [
                'error' => $e->getMessage(),
            ]);
            return null;
        }
    }

    /**
     * Parse TCMB XML response.
     *
     * @param string $xmlContent XML content from TCMB
     * @return array|null Parsed rates or null on failure
     */
    private function parseTCMBXml(string $xmlContent): ?array
    {
        try {
            $xml = new SimpleXMLElement($xmlContent);
            $rates = [];
            $date = isset($xml['Date']) ? Carbon::parse((string) $xml['Date']) : today();

            foreach ($xml->Currency as $currency) {
                $code = (string) $currency['CurrencyCode'];
                $buyingRate = (float) $currency->BanknoteBuying;
                $sellingRate = (float) $currency->BanknoteSelling;

                // Use selling rate (what customer pays to get foreign currency)
                if ($sellingRate > 0) {
                    $rates[] = [
                        'currency_code' => $code,
                        'rate' => $sellingRate,
                        'base_currency' => 'TRY',
                        'rate_date' => $date,
                        'source' => 'TCMB',
                    ];
                }
            }

            return $rates;
        } catch (\Exception $e) {
            Log::error('Error parsing TCMB XML', [
                'error' => $e->getMessage(),
            ]);
            return null;
        }
    }

    /**
     * Store rates in database and cache.
     *
     * @param array $rates Array of rate data
     * @return bool Success status
     */
    public function storeRates(array $rates): bool
    {
        try {
            foreach ($rates as $rateData) {
                FxRate::updateOrCreate(
                    [
                        'currency_code' => $rateData['currency_code'],
                        'rate_date' => $rateData['rate_date'],
                        'source' => $rateData['source'],
                    ],
                    $rateData
                );
            }

            // Cache the latest rates
            $this->cacheLatestRates();

            Log::info('FX rates stored successfully', [
                'count' => count($rates),
            ]);

            return true;
        } catch (\Exception $e) {
            Log::error('Error storing FX rates', [
                'error' => $e->getMessage(),
            ]);
            return false;
        }
    }

    /**
     * Cache latest rates for fast retrieval.
     */
    private function cacheLatestRates(): void
    {
        $rates = FxRate::latest('rate_date')
            ->where('rate_date', function ($query) {
                $query->selectRaw('MAX(rate_date)')->from('fx_rates');
            })
            ->get()
            ->keyBy('currency_code');

        Cache::put(self::CACHE_KEY, $rates, self::CACHE_TTL);
    }

    /**
     * Get latest rate for a currency.
     *
     * @param string $currencyCode Currency code (USD, EUR, etc.)
     * @param bool $useCache Whether to use cached rates
     * @return float|null Rate or null if not found
     */
    public function getLatestRate(string $currencyCode, bool $useCache = true): ?float
    {
        $currencyCode = strtoupper($currencyCode);

        if ($useCache) {
            $rates = Cache::remember(self::CACHE_KEY, self::CACHE_TTL, function () {
                return FxRate::latest('rate_date')
                    ->where('rate_date', function ($query) {
                        $query->selectRaw('MAX(rate_date)')->from('fx_rates');
                    })
                    ->get()
                    ->keyBy('currency_code');
            });

            return isset($rates[$currencyCode]) ? (float) $rates[$currencyCode]->rate : null;
        }

        return FxRate::getLatestRate($currencyCode);
    }

    /**
     * Get all latest rates.
     *
     * @param bool $useCache Whether to use cached rates
     * @return array Array of currency => rate
     */
    public function getAllLatestRates(bool $useCache = true): array
    {
        $rates = Cache::remember(self::CACHE_KEY, self::CACHE_TTL, function () {
            return FxRate::latest('rate_date')
                ->where('rate_date', function ($query) {
                    $query->selectRaw('MAX(rate_date)')->from('fx_rates');
                })
                ->get()
                ->keyBy('currency_code');
        });

        return $rates->map(fn($rate) => (float) $rate->rate)->toArray();
    }

    /**
     * Convert amount between currencies.
     *
     * @param float $amount Amount to convert
     * @param string $fromCurrency Source currency
     * @param string $toCurrency Target currency
     * @return float|null Converted amount or null on failure
     */
    public function convert(float $amount, string $fromCurrency, string $toCurrency): ?float
    {
        return FxRate::convert($amount, strtoupper($fromCurrency), strtoupper($toCurrency));
    }

    /**
     * Clear FX cache.
     */
    public function clearCache(): void
    {
        Cache::forget(self::CACHE_KEY);
    }
}
