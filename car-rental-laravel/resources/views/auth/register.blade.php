@extends('layouts.app')

@section('title', 'Kayıt Ol - Ertan Rent a Car')

@push('styles')
<style>
    .auth-container {
        min-height: calc(100vh - 200px);
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 50px 0;
        background: linear-gradient(135deg, #29ca8e 0%, #1dbf73 100%);
    }

    .auth-card {
        background: white;
        border-radius: 20px;
        box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
        overflow: hidden;
        max-width: 500px;
        width: 100%;
        animation: slideUp 0.5s ease;
    }

    @keyframes slideUp {
        from {
            opacity: 0;
            transform: translateY(50px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .auth-header {
        background: linear-gradient(135deg, #29ca8e 0%, #1dbf73 100%);
        padding: 40px 30px;
        text-align: center;
        color: white;
    }

    .auth-header h2 {
        color: white !important;
        -webkit-text-fill-color: white !important;
        margin: 0;
        font-size: 32px;
        font-weight: 700;
    }

    .auth-header p {
        margin: 10px 0 0;
        opacity: 0.9;
    }

    .auth-body {
        padding: 40px 30px;
    }

    .form-group {
        margin-bottom: 20px;
    }

    .form-group label {
        font-weight: 600;
        color: #2c3e50;
        margin-bottom: 8px;
        display: block;
    }

    .form-control {
        border: 2px solid #e0e0e0;
        border-radius: 10px;
        padding: 15px 20px;
        font-size: 16px;
        transition: all 0.3s ease;
    }

    .form-control:focus {
        border-color: #1a7f5a;
        box-shadow: 0 0 0 0.2rem rgba(41, 202, 142, 0.25);
        outline: none;
    }

    .btn-auth {
        width: 100%;
        padding: 15px;
        font-size: 18px;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 1px;
        border-radius: 50px;
        background: linear-gradient(135deg, #29ca8e 0%, #1dbf73 100%);
        border: none;
        color: white;
        margin-top: 10px;
    }

    .btn-auth:hover {
        transform: translateY(-3px);
        box-shadow: 0 10px 30px rgba(41, 202, 142, 0.4);
    }

    .auth-footer {
        text-align: center;
        padding: 20px 30px 30px;
        border-top: 1px solid #f0f0f0;
    }

    .auth-footer a {
        color: #1a7f5a;
        font-weight: 600;
        text-decoration: none;
    }

    .auth-footer a:hover {
        text-decoration: underline;
    }

    .alert {
        border-radius: 10px;
        padding: 15px 20px;
        margin-bottom: 20px;
    }
</style>
@endpush

@section('content')
<div class="auth-container">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-7">
                <div class="auth-card">
                    <div class="auth-header">
                        <h2>Kayıt Ol</h2>
                        <p>Yeni hesap oluşturun</p>
                    </div>

                    <div class="auth-body">
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul class="mb-0" style="padding-left: 20px;">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <form method="POST" action="{{ route('register') }}">
                            @csrf

                            <div class="form-group">
                                <label for="name">
                                    <i class="fa fa-user"></i> Ad Soyad
                                </label>
                                <input type="text"
                                       class="form-control"
                                       id="name"
                                       name="name"
                                       value="{{ old('name') }}"
                                       required
                                       autofocus
                                       placeholder="Adınız ve Soyadınız">
                            </div>

                            <div class="form-group">
                                <label for="email">
                                    <i class="fa fa-envelope"></i> Email Adresi
                                </label>
                                <input type="email"
                                       class="form-control"
                                       id="email"
                                       name="email"
                                       value="{{ old('email') }}"
                                       required
                                       placeholder="ornek@email.com">
                            </div>

                            <div class="form-group">
                                <label for="phone">
                                    <i class="fa fa-phone"></i> Telefon (Opsiyonel)
                                </label>
                                <input type="text"
                                       class="form-control"
                                       id="phone"
                                       name="phone"
                                       value="{{ old('phone') }}"
                                       placeholder="05XX XXX XX XX">
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="password">
                                            <i class="fa fa-lock"></i> Şifre
                                        </label>
                                        <input type="password"
                                               class="form-control"
                                               id="password"
                                               name="password"
                                               required
                                               placeholder="••••••••">
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="password_confirmation">
                                            <i class="fa fa-lock"></i> Şifre Tekrar
                                        </label>
                                        <input type="password"
                                               class="form-control"
                                               id="password_confirmation"
                                               name="password_confirmation"
                                               required
                                               placeholder="••••••••">
                                    </div>
                                </div>
                            </div>

                            <button type="submit" class="btn btn-auth">
                                <i class="fa fa-user-plus"></i> Kayıt Ol
                            </button>
                        </form>
                    </div>

                    <div class="auth-footer">
                        <p>Zaten hesabınız var mı? <a href="{{ route('login') }}">Giriş Yapın</a></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
