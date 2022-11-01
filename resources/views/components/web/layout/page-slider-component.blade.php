@if ($galleries->count() > 0)
    <div id="myCarousel" class="carousel carousel-dark slide" data-bs-ride="carousel">
        <!-- Carousel indicators -->
        <ol class="carousel-indicators">
            @foreach ($galleries as $gallery)
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
@endif
