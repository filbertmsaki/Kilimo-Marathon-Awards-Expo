@php($page_sliders = $galleries)
<section class="pt-130" data-aos="fade-up">
    @if ($page_sliders->count() > 0)
        <div id="myCarousel" class="carousel carousel-dark slide" data-bs-ride="carousel">
            <!-- Carousel indicators -->
            <ol class="carousel-indicators">
                @foreach ($page_sliders as $gallery)
                    <li data-bs-target="#myCarousel" data-bs-slide-to="{{ $loop->iteration - 1 }}"
                        class="@if ($loop->iteration - 1 == 0) active @endif"></li>
                @endforeach
            </ol>
            <!-- Wrapper for carousel items -->
            <div class="carousel-inner">
                @foreach ($galleries as $gallery)
                    <div class="carousel-item @if ($loop->iteration - 1 == 0) active @endif">
                        <img src="{{ asset($gallery->image_url) }}" class="d-block " alt="{{ $gallery->title }}">
                        <div class="carousel-caption">
                            <h1>{{ $gallery->title }}</h1>
                            <p class="lead">{{ $gallery->description }}</p>
                            <a href="{{ route('web.contactUs') }}" class="btn btn-sm btn-primary">Learn More</a>
                        </div><!-- end carousel-caption -->
                    </div>
                @endforeach
            </div>
            <!-- Carousel controls -->
            <a class="carousel-control-prev" href="#myCarousel" data-bs-slide="prev">
                <span class="carousel-control-prev-icon"></span>
            </a>
            <a class="carousel-control-next" href="#myCarousel" data-bs-slide="next">
                <span class="carousel-control-next-icon"></span>
            </a>
        </div>
    @else
        <div id="myCarousel" class="carousel carousel-dark slide" data-bs-ride="carousel">
            <!-- Carousel indicators -->
            <ol class="carousel-indicators">
                <li data-bs-target="#myCarousel" data-bs-slide-to="0" class="active"></li>
            </ol>
            <!-- Wrapper for carousel items -->
            <div class="carousel-inner">
                <div class="carousel-item active">
                    <img src="{{ asset('images/2024/IMG_6369.jpg') }}" class="d-block " alt="Slide 1">
                    <div class="carousel-caption">
                        <h1>Kilimo Marathon, Awards & Expo.</h1>
                        <p class="lead">A chance to the Agriculture sector to grow and go hand in hand with the current pace of digitized world.</p>
                        <a href="{{ route('web.contactUs') }}" class="btn btn-sm btn-primary">Contact Us</a>
                    </div><!-- end carousel-caption -->
                </div>
            </div>

        </div>
    @endif
</section>
