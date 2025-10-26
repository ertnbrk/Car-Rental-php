@extends('layouts.app')

@section('title', 'İletişim - Ertan Rent a Car')

@push('styles')
<style>
    .contact-header {
        background: linear-gradient(135deg, #29ca8e 0%, #1dbf73 100%);
        color: white;
        padding: 80px 0 60px;
        text-align: center;
    }

    .contact-header h1 {
        color: white !important;
        -webkit-text-fill-color: white !important;
        font-size: 48px;
        font-weight: 700;
        margin-bottom: 20px;
    }

    .contact-header p {
        font-size: 20px;
        opacity: 0.95;
    }

    .contact-section {
        padding: 80px 0;
        background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
    }

    .contact-card {
        background: white;
        border-radius: 20px;
        box-shadow: 0 20px 60px rgba(0, 0, 0, 0.1);
        padding: 40px;
        margin-bottom: 30px;
    }

    .contact-card h3 {
        background: linear-gradient(135deg, #29ca8e 0%, #1dbf73 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
        font-weight: 700;
        margin-bottom: 25px;
    }

    .contact-info-item {
        display: flex;
        align-items: center;
        margin-bottom: 20px;
        padding: 15px;
        background: linear-gradient(135deg, #f5f7fa 0%, #e0e7ee 100%);
        border-radius: 10px;
        transition: transform 0.3s ease;
    }

    .contact-info-item:hover {
        transform: translateX(10px);
    }

    .contact-info-item i {
        font-size: 24px;
        color: #1a7f5a;
        margin-right: 15px;
        width: 40px;
        text-align: center;
    }

    .contact-info-item div {
        flex: 1;
    }

    .contact-info-item strong {
        display: block;
        color: #2c3e50;
        font-weight: 700;
        margin-bottom: 5px;
    }

    .contact-info-item span {
        color: #666;
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

    .form-control, .form-select, textarea {
        border: 2px solid #e0e0e0;
        border-radius: 10px;
        padding: 15px 20px;
        font-size: 16px;
        transition: all 0.3s ease;
        width: 100%;
    }

    .form-control:focus, .form-select:focus, textarea:focus {
        border-color: #1a7f5a;
        box-shadow: 0 0 0 0.2rem rgba(41, 202, 142, 0.25);
        outline: none;
    }

    .btn-contact {
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

    .btn-contact:hover {
        transform: translateY(-3px);
        box-shadow: 0 10px 30px rgba(41, 202, 142, 0.4);
    }

    .alert {
        border-radius: 10px;
        padding: 15px 20px;
        margin-bottom: 20px;
    }

    .map-container {
        border-radius: 20px;
        overflow: hidden;
        box-shadow: 0 20px 60px rgba(0, 0, 0, 0.1);
        margin-top: 40px;
    }

    .map-container iframe {
        width: 100%;
        height: 400px;
        border: none;
    }
</style>
@endpush

@section('content')
<!-- CONTACT HEADER -->
<div class="contact-header">
    <div class="container">
        <h1>İletişim</h1>
        <p>Bize ulaşın, size yardımcı olmaktan mutluluk duyarız</p>
    </div>
</div>

<!-- CONTACT SECTION -->
<section class="contact-section">
    <div class="container">
        @if (session('success'))
            <div class="alert alert-success">
                <i class="fa fa-check-circle"></i> {{ session('success') }}
            </div>
        @endif

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
            <!-- Contact Information -->
            <div class="col-md-4">
                <div class="contact-card">
                    <h3><i class="fa fa-info-circle"></i> İletişim Bilgileri</h3>

                    <div class="contact-info-item">
                        <i class="fa fa-map-marker"></i>
                        <div>
                            <strong>Adres</strong>
                            <span>Kütahya Merkez Andız 5.Karadeniz Sokak Yesevi Yurdu</span>
                        </div>
                    </div>

                    <div class="contact-info-item">
                        <i class="fa fa-phone"></i>
                        <div>
                            <strong>Telefon</strong>
                            <span>555 331 5166</span>
                        </div>
                    </div>

                    <div class="contact-info-item">
                        <i class="fa fa-envelope"></i>
                        <div>
                            <strong>Email</strong>
                            <span>ertan.felek@ogr.dpu.edu.tr</span>
                        </div>
                    </div>

                    <div class="contact-info-item">
                        <i class="fa fa-clock-o"></i>
                        <div>
                            <strong>Çalışma Saatleri</strong>
                            <span>Pazartesi - Cuma: 09:00 - 18:00</span>
                            <span>Cumartesi: 10:00 - 16:00</span>
                        </div>
                    </div>

                    <div style="margin-top: 30px;">
                        <h3><i class="fa fa-share-alt"></i> Sosyal Medya</h3>
                        <div style="display: flex; gap: 15px; margin-top: 20px;">
                            <a href="#" style="display: inline-block; width: 50px; height: 50px; line-height: 50px; text-align: center; border-radius: 50%; background: linear-gradient(135deg, #29ca8e 0%, #1dbf73 100%); color: white; font-size: 24px; transition: transform 0.3s ease;">
                                <i class="fa fa-facebook"></i>
                            </a>
                            <a href="#" style="display: inline-block; width: 50px; height: 50px; line-height: 50px; text-align: center; border-radius: 50%; background: linear-gradient(135deg, #29ca8e 0%, #1dbf73 100%); color: white; font-size: 24px; transition: transform 0.3s ease;">
                                <i class="fa fa-twitter"></i>
                            </a>
                            <a href="#" style="display: inline-block; width: 50px; height: 50px; line-height: 50px; text-align: center; border-radius: 50%; background: linear-gradient(135deg, #29ca8e 0%, #1dbf73 100%); color: white; font-size: 24px; transition: transform 0.3s ease;">
                                <i class="fa fa-instagram"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Contact Form -->
            <div class="col-md-8">
                <div class="contact-card">
                    <h3><i class="fa fa-paper-plane"></i> Mesaj Gönderin</h3>

                    <form method="POST" action="{{ route('contact.store') }}">
                        @csrf

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="full_name">
                                        <i class="fa fa-user"></i> Ad Soyad
                                    </label>
                                    <input type="text"
                                           class="form-control"
                                           id="full_name"
                                           name="full_name"
                                           value="{{ old('full_name', auth()->user()->name ?? '') }}"
                                           required
                                           placeholder="Adınız ve Soyadınız">
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="email">
                                        <i class="fa fa-envelope"></i> Email
                                    </label>
                                    <input type="email"
                                           class="form-control"
                                           id="email"
                                           name="email"
                                           value="{{ old('email', auth()->user()->email ?? '') }}"
                                           required
                                           placeholder="ornek@email.com">
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="phone">
                                <i class="fa fa-phone"></i> Telefon
                            </label>
                            <input type="text"
                                   class="form-control"
                                   id="phone"
                                   name="phone"
                                   value="{{ old('phone', auth()->user()->phone ?? '') }}"
                                   placeholder="05XX XXX XX XX">
                        </div>

                        <div class="form-group">
                            <label for="subject">
                                <i class="fa fa-tag"></i> Konu
                            </label>
                            <input type="text"
                                   class="form-control"
                                   id="subject"
                                   name="subject"
                                   value="{{ old('subject') }}"
                                   required
                                   placeholder="Mesaj konusu">
                        </div>

                        <div class="form-group">
                            <label for="message">
                                <i class="fa fa-comment"></i> Mesajınız
                            </label>
                            <textarea class="form-control"
                                      id="message"
                                      name="message"
                                      rows="6"
                                      required
                                      placeholder="Mesajınızı buraya yazın...">{{ old('message') }}</textarea>
                        </div>

                        <button type="submit" class="btn btn-contact">
                            <i class="fa fa-paper-plane"></i> Mesaj Gönder
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <!-- Map (Optional) -->
        <div class="row">
            <div class="col-12">
                <div class="map-container">
                    <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d97355.73424641768!2d29.883724749999998!3d39.424215799999995!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x14c947cf762e554f%3A0x4b5a0e8d6b5e0e0a!2zS8O8dGFoeWE!5e0!3m2!1str!2str!4v1234567890123"
                            allowfullscreen=""
                            loading="lazy"
                            referrerpolicy="no-referrer-when-downgrade"></iframe>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
