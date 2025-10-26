<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=Edge">
    <meta name="description" content="">
    <meta name="keywords" content="">
    <meta name="author" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'Ertan Rent a Car')</title>

    <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/font-awesome.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/owl.carousel.css') }}">
    <link rel="stylesheet" href="{{ asset('css/owl.theme.default.min.css') }}">
    <!-- MAIN CSS -->
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <!-- ENHANCED CSS -->
    <link rel="stylesheet" href="{{ asset('css/enhancements.css') }}">

    @stack('styles')
</head>
<body id="top" data-spy="scroll" data-target=".navbar-collapse" data-offset="50">

    <!-- PRE LOADER -->
    <section class="preloader">
        <div class="spinner">
            <span class="spinner-rotate"></span>
        </div>
    </section>

    <!-- MENU -->
    <section class="navbar custom-navbar navbar-fixed-top" role="navigation">
        <div class="container">
            <div class="navbar-header">
                <button class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                    <span class="icon icon-bar"></span>
                    <span class="icon icon-bar"></span>
                    <span class="icon icon-bar"></span>
                </button>

                <!-- lOGO TEXT HERE -->
                <a href="{{ route('home') }}" class="navbar-brand">Ertan Car Rental</a>
            </div>

            <!-- MENU LINKS -->
            <div class="collapse navbar-collapse">
                <ul class="nav navbar-nav navbar-nav-first">
                    <li class="{{ request()->routeIs('home') ? 'active' : '' }}">
                        <a href="{{ route('home') }}">Ana Ekran</a>
                    </li>
                    <li class="{{ request()->routeIs('fleet.*') ? 'active' : '' }}">
                        <a href="{{ route('fleet.index') }}">Garaj</a>
                    </li>

                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                            Daha Fazla<span class="caret"></span>
                        </a>

                        <ul class="dropdown-menu">
                            @php
                                $pages = \App\Models\Page::published()->orderBy('order')->get();
                                $contactPage = null;
                            @endphp

                            @foreach($pages as $page)
                                @if($page->title == 'İletişim' || $page->title == 'Contact')
                                    @php
                                        $contactPage = $page;
                                        continue;
                                    @endphp
                                @endif
                                <li><a href="{{ route('pages.show', $page->slug) }}">{{ $page->title }}</a></li>
                            @endforeach
                        </ul>
                    </li>

                    @if($contactPage)
                        <li><a href="{{ route('pages.show', $contactPage->slug) }}">{{ $contactPage->title }}</a></li>
                    @endif

                    @auth
                        @can('admin')
                            <li><a href="{{ route('admin.dashboard') }}" class="login">Admin</a></li>
                        @endcan
                        <li><a href="{{ route('logout') }}" class="register"
                               onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                            Çıkış
                        </a></li>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                            @csrf
                        </form>
                    @else
                        <li><a href="{{ route('register') }}" class="register">Kayıt Ol</a></li>
                        <li><a href="{{ route('login') }}" class="login">Giriş</a></li>
                    @endauth
                </ul>
            </div>
        </div>
    </section>

    <!-- MAIN CONTENT -->
    @yield('content')

    <!-- FOOTER -->
    <footer id="footer">
        <div class="container">
            <div class="row">
                <div class="col-md-4 col-sm-6">
                    <div class="footer-info">
                        <div class="section-title">
                            <h2>Merkez</h2>
                        </div>
                        <address>
                            <p>Kütahya Merkez Andız 5.Karadeniz Sokak Yesevi Yurdu</p>
                        </address>

                        <ul class="social-icon">
                            <li><a href="#" class="fa fa-facebook-square" attr="facebook icon"></a></li>
                            <li><a href="#" class="fa fa-twitter"></a></li>
                            <li><a href="#" class="fa fa-instagram"></a></li>
                        </ul>

                        <div class="copyright-text">
                            <p>Copyright &copy; {{ date('Y') }} ErtanFELEK</p>
                        </div>
                    </div>
                </div>

                <div class="col-md-4 col-sm-6">
                    <div class="footer-info">
                        <div class="section-title">
                            <h2>İletişim Bilgileri</h2>
                        </div>
                        <address>
                            <p>555 331 5166</p>
                            <p><a href="mailto:ertan.felek@ogr.dpu.edu.tr">ertan.felek@ogr.dpu.edu.tr</a></p>
                        </address>

                        <div class="footer_menu">
                            <h2>Hızlı erişim</h2>
                            <ul>
                                <li><a href="{{ route('home') }}">Home</a></li>
                                <li><a href="{{ route('fleet.index') }}">Garaj</a></li>
                                @if(isset($pages))
                                    @foreach($pages->take(2) as $page)
                                        <li><a href="{{ route('pages.show', $page->slug) }}">{{ $page->title }}</a></li>
                                    @endforeach
                                @endif
                            </ul>
                        </div>
                    </div>
                </div>

                <div class="col-md-4 col-sm-12">
                    <div class="footer-info newsletter-form">
                        <div class="section-title">
                            <h2>Tekliflerin size iletilmesi için</h2>
                        </div>
                        <div>
                            <div class="form-group">
                                <form action="#" method="get">
                                    <input type="email" class="form-control" placeholder="Enter your email" name="email" id="email" required>
                                    <input type="submit" class="form-control" name="submit" id="form-submit" value="Send me">
                                </form>
                                <span><sup>*</sup>email bilgileriniz paylaşılmayacaktır!</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </footer>

    <!-- SCRIPTS -->
    <script src="{{ asset('js/jquery.js') }}"></script>
    <script src="{{ asset('js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('js/owl.carousel.min.js') }}"></script>
    <script src="{{ asset('js/smoothscroll.js') }}"></script>
    <script src="{{ asset('js/custom.js') }}"></script>

    @stack('scripts')
</body>
</html>
