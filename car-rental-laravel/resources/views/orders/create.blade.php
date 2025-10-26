@extends('layouts.app')

@section('title', 'Araç Kiralama - Ertan Rent a Car')

@push('styles')
<style>
    .order-container {
        min-height: calc(100vh - 200px);
        padding: 50px 0;
        background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
    }

    .order-header {
        background: linear-gradient(135deg, #29ca8e 0%, #1dbf73 100%);
        color: white;
        padding: 60px 0;
        text-align: center;
        margin-bottom: 50px;
    }

    .order-header h1 {
        color: white !important;
        -webkit-text-fill-color: white !important;
        font-size: 42px;
        font-weight: 700;
        margin-bottom: 15px;
    }

    .order-header p {
        font-size: 18px;
        opacity: 0.95;
    }

    .order-card {
        background: white;
        border-radius: 20px;
        box-shadow: 0 20px 60px rgba(0, 0, 0, 0.1);
        overflow: hidden;
        margin-bottom: 30px;
    }

    .order-card-header {
        background: linear-gradient(135deg, #29ca8e 0%, #1dbf73 100%);
        padding: 25px 30px;
        color: white;
    }

    .order-card-header h3 {
        color: white !important;
        -webkit-text-fill-color: white !important;
        margin: 0;
        font-size: 24px;
        font-weight: 700;
    }

    .order-card-body {
        padding: 30px;
    }

    .car-info-box {
        background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
        border-radius: 15px;
        padding: 20px;
        margin-bottom: 30px;
    }

    .car-info-box h4 {
        color: #2c3e50;
        font-weight: 700;
        margin-bottom: 15px;
    }

    .car-detail {
        display: flex;
        align-items: center;
        margin-bottom: 10px;
        color: #666;
    }

    .car-detail i {
        color: #1a7f5a;
        margin-right: 10px;
        width: 20px;
    }

    .form-group {
        margin-bottom: 25px;
    }

    .form-group label {
        font-weight: 600;
        color: #2c3e50;
        margin-bottom: 8px;
        display: block;
    }

    .form-control, .form-select {
        border: 2px solid #e0e0e0;
        border-radius: 10px;
        padding: 15px 20px;
        font-size: 16px;
        transition: all 0.3s ease;
        width: 100%;
    }

    .form-control:focus, .form-select:focus {
        border-color: #1a7f5a;
        box-shadow: 0 0 0 0.2rem rgba(41, 202, 142, 0.25);
        outline: none;
    }

    .btn-order {
        width: 100%;
        padding: 18px;
        font-size: 20px;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 1px;
        border-radius: 50px;
        background: linear-gradient(135deg, #29ca8e 0%, #1dbf73 100%);
        border: none;
        color: white;
        margin-top: 20px;
    }

    .btn-order:hover {
        transform: translateY(-3px);
        box-shadow: 0 10px 30px rgba(41, 202, 142, 0.4);
    }

    .alert {
        border-radius: 10px;
        padding: 15px 20px;
        margin-bottom: 20px;
    }

    .discount-badge {
        display: inline-block;
        background: linear-gradient(135deg, #28a745 0%, #20c997 100%);
        color: white;
        padding: 10px 20px;
        border-radius: 50px;
        font-weight: 600;
        margin-bottom: 20px;
    }

    .price-summary {
        background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
        border-radius: 15px;
        padding: 25px;
        margin-top: 30px;
    }

    .price-row {
        display: flex;
        justify-content: space-between;
        margin-bottom: 15px;
        font-size: 16px;
    }

    .price-row.total {
        font-size: 24px;
        font-weight: 700;
        border-top: 2px solid #29ca8e;
        padding-top: 15px;
        margin-top: 15px;
        background: linear-gradient(135deg, #29ca8e 0%, #1dbf73 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
    }

    .required-star {
        color: #e74c3c;
    }
</style>
@endpush

@section('content')
<!-- ORDER HEADER -->
<div class="order-header">
    <div class="container">
        <h1>Araç Kiralama</h1>
        <p>Rezervasyon bilgilerinizi girin</p>
    </div>
</div>

<div class="order-container">
    <div class="container">
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0" style="padding-left: 20px;">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="row">
            <!-- Car Information Sidebar -->
            <div class="col-md-4">
                @if($car)
                    <div class="order-card">
                        <div class="order-card-header">
                            <h3><i class="fa fa-car"></i> Seçilen Araç</h3>
                        </div>
                        <div class="order-card-body">
                            @if($car->image_path)
                                <img src="{{ asset('storage/' . $car->image_path) }}"
                                     alt="{{ $car->name }}"
                                     style="width: 100%; border-radius: 10px; margin-bottom: 20px;">
                            @endif

                            <div class="car-info-box">
                                <h4>{{ $car->name }}</h4>
                                <div class="car-detail">
                                    <i class="fa fa-users"></i>
                                    <span>{{ $car->capacity }} Kişi</span>
                                </div>
                                <div class="car-detail">
                                    <i class="fa fa-cog"></i>
                                    <span>{{ $car->transmission == 'automatic' ? 'Otomatik' : 'Manuel' }}</span>
                                </div>
                                <div class="car-detail">
                                    <i class="fa fa-suitcase"></i>
                                    <span>{{ $car->luggage }} L Bagaj</span>
                                </div>
                                <div class="car-detail">
                                    <i class="fa fa-calendar"></i>
                                    <span>{{ $car->year }}</span>
                                </div>
                                <div class="car-detail">
                                    <i class="fa fa-money"></i>
                                    <span style="font-size: 20px; font-weight: 700; color: #1a7f5a;">
                                        {{ number_format($car->daily_price, 0) }} TRY / Gün
                                    </span>
                                </div>
                            </div>

                            @if($userDiscount > 0)
                                <div class="discount-badge">
                                    <i class="fa fa-tag"></i> %{{ $userDiscount }} İndirim Hakkınız Var!
                                </div>
                            @endif
                        </div>
                    </div>
                @endif
            </div>

            <!-- Order Form -->
            <div class="col-md-8">
                <div class="order-card">
                    <div class="order-card-header">
                        <h3><i class="fa fa-edit"></i> Rezervasyon Bilgileri</h3>
                    </div>
                    <div class="order-card-body">
                        <form method="POST" action="{{ route('orders.store') }}">
                            @csrf

                            @if($car)
                                <input type="hidden" name="car_id" value="{{ $car->id }}">
                            @else
                                <div class="alert alert-warning">
                                    <i class="fa fa-exclamation-triangle"></i>
                                    Lütfen önce bir araç seçin.
                                </div>
                            @endif

                            <!-- Guest Information (only for non-authenticated users) -->
                            @guest
                                <h5 style="color: #2c3e50; margin-bottom: 20px;">
                                    <i class="fa fa-user"></i> Kişisel Bilgiler
                                </h5>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="customer_name">
                                                Ad Soyad <span class="required-star">*</span>
                                            </label>
                                            <input type="text"
                                                   class="form-control"
                                                   id="customer_name"
                                                   name="customer_name"
                                                   value="{{ old('customer_name') }}"
                                                   required>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="customer_email">
                                                Email <span class="required-star">*</span>
                                            </label>
                                            <input type="email"
                                                   class="form-control"
                                                   id="customer_email"
                                                   name="customer_email"
                                                   value="{{ old('customer_email') }}"
                                                   required>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="customer_phone">
                                        Telefon <span class="required-star">*</span>
                                    </label>
                                    <input type="text"
                                           class="form-control"
                                           id="customer_phone"
                                           name="customer_phone"
                                           value="{{ old('customer_phone') }}"
                                           placeholder="05XX XXX XX XX"
                                           required>
                                </div>
                                <hr style="margin: 30px 0;">
                            @endguest

                            <h5 style="color: #2c3e50; margin-bottom: 20px;">
                                <i class="fa fa-calendar"></i> Kiralama Detayları
                            </h5>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="start_date">
                                            Başlangıç Tarihi <span class="required-star">*</span>
                                        </label>
                                        <input type="date"
                                               class="form-control"
                                               id="start_date"
                                               name="start_date"
                                               value="{{ old('start_date') }}"
                                               min="{{ date('Y-m-d') }}"
                                               required>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="end_date">
                                            Bitiş Tarihi <span class="required-star">*</span>
                                        </label>
                                        <input type="date"
                                               class="form-control"
                                               id="end_date"
                                               name="end_date"
                                               value="{{ old('end_date') }}"
                                               min="{{ date('Y-m-d') }}"
                                               required>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="pickup_location">
                                            Alış Konumu <span class="required-star">*</span>
                                        </label>
                                        <input type="text"
                                               class="form-control"
                                               id="pickup_location"
                                               name="pickup_location"
                                               value="{{ old('pickup_location') }}"
                                               placeholder="Örn: Atatürk Havalimanı"
                                               required>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="return_location">
                                            Teslim Konumu <span class="required-star">*</span>
                                        </label>
                                        <input type="text"
                                               class="form-control"
                                               id="return_location"
                                               name="return_location"
                                               value="{{ old('return_location') }}"
                                               placeholder="Örn: Sabiha Gökçen Havalimanı"
                                               required>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="notes">
                                    Notlar (Opsiyonel)
                                </label>
                                <textarea class="form-control"
                                          id="notes"
                                          name="notes"
                                          rows="4"
                                          placeholder="Özel istekleriniz veya notlarınız...">{{ old('notes') }}</textarea>
                            </div>

                            @if($car)
                                <button type="submit" class="btn btn-order">
                                    <i class="fa fa-check-circle"></i> Rezervasyonu Tamamla
                                </button>
                            @else
                                <a href="{{ route('fleet.index') }}" class="btn btn-order">
                                    <i class="fa fa-car"></i> Araç Seç
                                </a>
                            @endif
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
