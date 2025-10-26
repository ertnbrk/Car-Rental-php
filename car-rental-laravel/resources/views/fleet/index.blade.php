@extends('layouts.app')

@section('title', 'Araç Filosu - Ertan Rent a Car')

@push('styles')
<style>
    .fleet-header {
        background: linear-gradient(135deg, #29ca8e 0%, #1dbf73 100%);
        color: white;
        padding: 80px 0 60px;
        text-align: center;
    }

    .fleet-header h1 {
        color: white !important;
        -webkit-text-fill-color: white !important;
        font-size: 48px;
        font-weight: 700;
        margin-bottom: 20px;
    }

    .fleet-header p {
        font-size: 20px;
        opacity: 0.95;
    }

    .fx-rates-card {
        background: white;
        border-radius: 20px;
        box-shadow: 0 10px 40px rgba(0, 0, 0, 0.1);
        padding: 30px;
        margin-top: -50px;
        position: relative;
        z-index: 10;
    }

    .fx-rates-card h3 {
        background: linear-gradient(135deg, #29ca8e 0%, #1dbf73 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
        font-weight: 700;
        margin-bottom: 20px;
    }

    .fx-rate-item {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 15px 20px;
        margin-bottom: 10px;
        background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
        border-radius: 10px;
        transition: transform 0.3s ease;
    }

    .fx-rate-item:hover {
        transform: translateX(10px);
    }

    .fx-rate-currency {
        font-weight: 700;
        font-size: 18px;
        color: #2c3e50;
    }

    .fx-rate-value {
        font-weight: 700;
        font-size: 18px;
        color: #1a7f5a;
    }

    .filters-card {
        background: white;
        border-radius: 20px;
        box-shadow: 0 10px 40px rgba(0, 0, 0, 0.1);
        padding: 30px;
        margin-bottom: 40px;
    }

    .filters-card h3 {
        background: linear-gradient(135deg, #29ca8e 0%, #1dbf73 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
        font-weight: 700;
        margin-bottom: 25px;
    }

    .form-label {
        font-weight: 600;
        color: #2c3e50;
        margin-bottom: 8px;
    }

    .form-control, .form-select {
        border: 2px solid #e0e0e0;
        border-radius: 10px;
        padding: 12px 15px;
    }

    .form-control:focus, .form-select:focus {
        border-color: #29ca8e;
        box-shadow: 0 0 0 0.2rem rgba(41, 202, 142, 0.25);
    }

    .btn-filter {
        background: linear-gradient(135deg, #29ca8e 0%, #1dbf73 100%);
        border: none;
        color: white;
        padding: 12px 30px;
        border-radius: 10px;
        font-weight: 600;
    }

    .btn-filter:hover {
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(41, 202, 142, 0.4);
    }

    .car-card {
        background: white;
        border-radius: 20px;
        overflow: hidden;
        box-shadow: 0 10px 40px rgba(0, 0, 0, 0.1);
        transition: all 0.3s ease;
        margin-bottom: 30px;
        height: 100%;
    }

    .car-card:hover {
        transform: translateY(-10px);
        box-shadow: 0 20px 60px rgba(0, 0, 0, 0.15);
    }

    .car-image {
        position: relative;
        overflow: hidden;
        height: 250px;
    }

    .car-image img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.5s ease;
    }

    .car-card:hover .car-image img {
        transform: scale(1.1);
    }

    .car-badge {
        position: absolute;
        top: 15px;
        right: 15px;
        background: linear-gradient(135deg, #29ca8e 0%, #1dbf73 100%);
        color: white;
        padding: 8px 15px;
        border-radius: 20px;
        font-weight: 600;
        font-size: 14px;
    }

    .car-body {
        padding: 25px;
    }

    .car-title {
        font-size: 24px;
        font-weight: 700;
        color: #2c3e50;
        margin-bottom: 15px;
    }

    .car-features {
        display: flex;
        flex-wrap: wrap;
        gap: 15px;
        margin: 20px 0;
    }

    .car-feature {
        display: flex;
        align-items: center;
        color: #666;
        font-size: 14px;
    }

    .car-feature i {
        color: #1a7f5a;
        margin-right: 5px;
        font-size: 16px;
    }

    .car-price {
        font-size: 32px;
        font-weight: 700;
        background: linear-gradient(135deg, #29ca8e 0%, #1dbf73 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
        margin: 15px 0;
    }

    .car-price small {
        font-size: 16px;
        color: #666;
    }

    .btn-rent {
        width: 100%;
        background: linear-gradient(135deg, #29ca8e 0%, #1dbf73 100%);
        color: white;
        border: none;
        padding: 12px;
        border-radius: 10px;
        font-weight: 600;
        text-transform: uppercase;
    }

    .btn-rent:hover {
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(41, 202, 142, 0.4);
    }

    .no-cars-message {
        text-align: center;
        padding: 60px 20px;
        background: white;
        border-radius: 20px;
        box-shadow: 0 10px 40px rgba(0, 0, 0, 0.1);
    }

    .no-cars-message i {
        font-size: 80px;
        color: #1a7f5a;
        margin-bottom: 20px;
    }

    .no-cars-message h3 {
        color: #2c3e50;
        margin-bottom: 10px;
    }
</style>
@endpush

@section('content')
<!-- FLEET HEADER -->
<div class="fleet-header">
    <div class="container">
        <h1>Araç Filosu</h1>
        <p>Her ihtiyaca uygun binlerce araçla hizmetinizdeyiz</p>
    </div>
</div>

<!-- FX RATES -->
<section style="padding-top: 0;">
    <div class="container">
        @if(!empty($fxRates))
        <div class="fx-rates-card">
            <h3><i class="fa fa-exchange"></i> Güncel Döviz Kurları</h3>
            <div class="row">
                @foreach(['USD', 'EUR', 'GBP'] as $currency)
                    @if(isset($fxRates[$currency]))
                    <div class="col-md-4">
                        <div class="fx-rate-item">
                            <span class="fx-rate-currency">{{ $currency }}</span>
                            <span class="fx-rate-value">{{ number_format($fxRates[$currency], 4) }} TRY</span>
                        </div>
                    </div>
                    @endif
                @endforeach
            </div>
        </div>
        @endif
    </div>
</section>

<!-- FILTERS -->
<section>
    <div class="container">
        <div class="filters-card">
            <h3><i class="fa fa-filter"></i> Filtrele</h3>
            <form method="GET" action="{{ route('fleet.index') }}">
                <div class="row g-3">
                    <div class="col-md-3">
                        <label class="form-label">Ara</label>
                        <input type="text"
                               name="search"
                               class="form-control"
                               placeholder="Araç adı veya özellik"
                               value="{{ $filters['search'] ?? '' }}">
                    </div>

                    <div class="col-md-2">
                        <label class="form-label">Vites</label>
                        <select name="transmission" class="form-select">
                            <option value="">Tümü</option>
                            <option value="automatic" {{ ($filters['transmission'] ?? '') === 'automatic' ? 'selected' : '' }}>
                                Otomatik
                            </option>
                            <option value="manual" {{ ($filters['transmission'] ?? '') === 'manual' ? 'selected' : '' }}>
                                Manuel
                            </option>
                        </select>
                    </div>

                    <div class="col-md-2">
                        <label class="form-label">Min. Kapasite</label>
                        <input type="number"
                               name="capacity"
                               class="form-control"
                               min="1"
                               max="50"
                               value="{{ $filters['capacity'] ?? '' }}">
                    </div>

                    <div class="col-md-2">
                        <label class="form-label">Min. Fiyat</label>
                        <input type="number"
                               name="min_price"
                               class="form-control"
                               min="0"
                               step="0.01"
                               placeholder="0 TRY"
                               value="{{ $filters['min_price'] ?? '' }}">
                    </div>

                    <div class="col-md-2">
                        <label class="form-label">Max. Fiyat</label>
                        <input type="number"
                               name="max_price"
                               class="form-control"
                               min="0"
                               step="0.01"
                               placeholder="1000 TRY"
                               value="{{ $filters['max_price'] ?? '' }}">
                    </div>

                    <div class="col-md-1 d-flex align-items-end">
                        <button type="submit" class="btn btn-filter w-100">
                            <i class="fa fa-search"></i>
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</section>

<!-- CARS LISTING -->
<section style="background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);">
    <div class="container">
        <div class="row">
            @forelse($cars as $car)
                <div class="col-md-4 col-sm-6 mb-4">
                    <div class="car-card">
                        <div class="car-image">
                            @if($car->image_path)
                                <img src="{{ asset('storage/' . $car->image_path) }}" alt="{{ $car->name }}">
                            @else
                                <img src="{{ asset('images/default-car.jpg') }}" alt="{{ $car->name }}">
                            @endif
                            @if($car->stock > 0)
                                <span class="car-badge">
                                    <i class="fa fa-check-circle"></i> Müsait
                                </span>
                            @else
                                <span class="car-badge" style="background: #e74c3c;">
                                    <i class="fa fa-times-circle"></i> Yok
                                </span>
                            @endif
                        </div>
                        <div class="car-body">
                            <h3 class="car-title">{{ $car->name }}</h3>

                            <div class="car-features">
                                <span class="car-feature">
                                    <i class="fa fa-users"></i> {{ $car->capacity }} Kişi
                                </span>
                                <span class="car-feature">
                                    <i class="fa fa-cog"></i> {{ $car->transmission == 'automatic' ? 'Otomatik' : 'Manuel' }}
                                </span>
                                <span class="car-feature">
                                    <i class="fa fa-suitcase"></i> {{ $car->luggage }} L
                                </span>
                                <span class="car-feature">
                                    <i class="fa fa-calendar"></i> {{ $car->year }}
                                </span>
                            </div>

                            <div class="car-price">
                                {{ number_format($car->daily_price, 0) }} TRY
                                <small>/ Gün</small>
                            </div>

                            @if($car->stock > 0)
                                <a href="{{ route('orders.create', ['car_id' => $car->id]) }}" class="btn btn-rent">
                                    <i class="fa fa-car"></i> Şimdi Kirala
                                </a>
                            @else
                                <button class="btn btn-rent" style="background: #95a5a6; cursor: not-allowed;" disabled>
                                    <i class="fa fa-ban"></i> Stokta Yok
                                </button>
                            @endif
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12">
                    <div class="no-cars-message">
                        <i class="fa fa-car"></i>
                        <h3>Araç Bulunamadı</h3>
                        <p>Lütfen daha sonra tekrar kontrol edin veya filtrelerinizi ayarlayın.</p>
                    </div>
                </div>
            @endforelse
        </div>

        <!-- PAGINATION -->
        @if($cars->hasPages())
            <div class="row mt-4">
                <div class="col-12 d-flex justify-content-center">
                    {{ $cars->links() }}
                </div>
            </div>
        @endif
    </div>
</section>
@endsection

