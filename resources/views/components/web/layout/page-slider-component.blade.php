@php($page_galleries = $galleries)
<style>
    .carousel-item:after {
        opacity: 0;
    }
</style>
@if ($page_galleries->count() > 0)
    <div id="myCarousel" class="carousel carousel-dark slide" data-bs-ride="carousel">
        <!-- Carousel indicators -->
        <ol class="carousel-indicators">
            @foreach ($page_galleries as $gallery)
                <li data-bs-target="#myCarousel" data-bs-slide-to="{{ $loop->iteration - 1 }}"
                    class="@if ($loop->iteration - 1 == 0) active @endif"></li>
            @endforeach
        </ol>
        <!-- Wrapper for carousel items -->
        <div class="carousel-inner">
            @foreach ($galleries as $gallery)
                <div class="carousel-item @if ($loop->iteration - 1 == 0) active @endif">
                    <img src="{{ asset($gallery->image_url) }}" class="d-block " alt="Slide 1">
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
                @if ($page == 'kilimo_marathon')
                <img src="{{ asset('images/marathon-1.jpg') }}" class="d-block " alt="Kilimo Marathon">
                @elseif ($page == 'kilimo_award')
                <img src="{{ asset('images/IMG_6837.jpg') }}" class="d-block " alt="Kilimo Award">
                @elseif ($page == 'kilimo_expo')
                <img src="{{ asset('images/IMG_5273.jpg') }}" class="d-block " alt="Kilimo Expo">
                @endif
            </div>
        </div>
    </div>
@endif
