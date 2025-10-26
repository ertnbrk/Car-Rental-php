@extends('layouts.app')

@section('title', 'Ertan Rent a Car')

@section('content')
    <!-- HOME -->
    <section id="home">
        <div class="row">
            <div class="owl-carousel owl-theme home-slider" style="position:relative;">
                @forelse($sliders as $slider)
                    @if($slider->image_path)
                        <img src="{{ asset('storage/' . $slider->image_path) }}" style="height:100%;" alt="{{ $slider->title }}">
                    @endif
                @empty
                    <img src="{{ asset('images/home-bg.jpg') }}" style="height:100%;" alt="Home">
                @endforelse
            </div>
        </div>
    </section>

    <main>
        <section>
            <div class="container">
                <div class="row">
                    <div class="col-md-12 col-sm-12">
                        <div class="text-center">
                            <h2>Hakkımızda</h2>
                            <br>
                            <p class="lead">Özel araçlardan kargo kamyonetlerine kadar geniş bir yelpazede kiralama seçenekleri sunuyoruz.Prestijli kiralık arabalarımızdan biriyle şık bir şekilde gelin. Dünyanın önde gelen üreticilerinden özel, lüks ve sportif kiralık araç yelpazemizi keşfedin.</p>
                            @php
                                $aboutPage = \App\Models\Page::where('slug', 'hakkimizda')->orWhere('slug', 'about-us')->first();
                            @endphp
                            @if($aboutPage)
                                <a href="{{ route('pages.show', $aboutPage->slug) }}" class="section-btn btn btn-primary btn-block">Daha fazla öğren</a>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- TESTIMONIALS -->
        @if($testimonials->count() > 0)
        <section id="testimonial">
            <div class="container">
                <div class="row">
                    <div class="col-md-12 col-sm-12">
                        <div class="section-title text-center">
                            <h2>Görüşler <small>Ülkemizin her bir köşesinden</small></h2>
                        </div>

                        <div class="owl-carousel owl-theme owl-client">
                            @foreach($testimonials as $testimonial)
                                <div class="col-md-4 col-sm-4">
                                    <div class="item">
                                        <div class="tst-image">
                                            @if($testimonial->image_path)
                                                <img src="{{ asset('storage/' . $testimonial->image_path) }}" class="img-responsive" alt="{{ $testimonial->name }}">
                                            @else
                                                <img src="{{ asset('images/tst-image1.jpg') }}" class="img-responsive" alt="{{ $testimonial->name }}">
                                            @endif
                                        </div>
                                        <div class="tst-author">
                                            <h4 style="color: white !important;">{{ $testimonial->name }}</h4>
                                            @if($testimonial->title)
                                                <span style="color: rgba(255, 255, 255, 0.9) !important;">{{ $testimonial->title }}</span>
                                            @endif
                                        </div>
                                        <p style="color: white !important;">{{ $testimonial->comment }}</p>
                                        <div class="tst-rating">
                                            @for($i = 0; $i < $testimonial->rating; $i++)
                                                <i class="fa fa-star" style="color: #ffd700 !important;"></i>
                                            @endfor
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </section>
        @endif
    </main>

    <!-- CONTACT -->
    <section id="contact">
        <div class="container">
            <div class="row">
                <div class="col-md-6 col-sm-12">
                    <form id="contact-form" role="form" action="{{ route('contact.store') }}" method="post">
                        @csrf
                        <div class="col-md-12 col-sm-12">
                            <input type="text" class="form-control" placeholder="Tam isminizi giriniz" name="name" required>
                            <input type="email" class="form-control" placeholder="Email adresinizi giriniz" name="email" required>
                            <textarea class="form-control" rows="6" placeholder="Mesajınızı giriniz" name="message" required></textarea>
                        </div>

                        <div class="col-md-4 col-sm-12">
                            <input type="submit" class="form-control" name="sendmessage" value="Gönder">
                        </div>
                    </form>
                </div>

                <div class="col-md-6 col-sm-12">
                    <div class="contact-image">
                        <img src="{{ asset('images/contact-1-600x400.jpg') }}" class="img-responsive" alt="Contact">
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@push('scripts')
<script>
$(document).ready(function() {
    $('.home-slider').owlCarousel({
        items: 1,
        loop: true,
        autoplay: true,
        autoplayTimeout: 5000,
        autoplayHoverPause: true,
        nav: false,
        dots: false
    });

    $('.owl-client').owlCarousel({
        items: 3,
        loop: true,
        autoplay: true,
        autoplayTimeout: 4000,
        margin: 30,
        responsive: {
            0: { items: 1 },
            768: { items: 2 },
            992: { items: 3 }
        }
    });
});
</script>
@endpush
