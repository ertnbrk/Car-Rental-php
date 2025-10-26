<?php

return [

    /*
    |--------------------------------------------------------------------------
    | FX Rate Configuration
    |--------------------------------------------------------------------------
    |
    | Configuration for foreign exchange rate fetching and caching.
    |
    */

    /**
     * URL to fetch FX rates from TCMB (Turkish Central Bank).
     */
    'tcmb_url' => env('FX_TCMB_URL', 'https://www.tcmb.gov.tr/kurlar/today.xml'),

    /**
     * Cache TTL for FX rates in seconds (default: 1 hour).
     */
    'cache_ttl' => env('FX_CACHE_TTL', 3600),

    /**
     * Default currencies to fetch and display.
     */
    'currencies' => [
        'USD',
        'EUR',
        'GBP',
    ],

    /**
     * Base currency (usually TRY for Turkish applications).
     */
    'base_currency' => env('FX_BASE_CURRENCY', 'TRY'),

    /**
     * Offer configuration.
     */
    'offers' => [
        /**
         * Every Nth order gets a discount (0 to disable).
         */
        'nth' => env('OFFERS_NTH', 5),

        /**
         * Discount percentage for qualifying orders.
         */
        'percent' => env('OFFERS_PERCENT', 10),
    ],

];
