<div class="product-image-sliders">
    <div class="card card-radius">
        <div id="carouselExampleIndicators" class="carousel slide d-block m-3" data-ride="carousel">
            <ol class="carousel-indicators">
                @for ($index = 0; $index < count($imagePaths); $index++)
                    <li data-target="#carouselExampleIndicators" data-slide-to="{{ $index }}"
                        class="{{ $index === 0 ? 'active' : '' }}">
                    </li>
                @endfor
            </ol>
            <div class="carousel-inner">
                @foreach ($imagePaths as $index => $imagePath)
                    <div class="carousel-item {{ $index === 0 ? 'active' : '' }}">
                        <img class="d-block w-100" src="{{ asset('storage/' . $imagePath) }}"
                            alt="Slide {{ $index }}">
                    </div>
                @endforeach
            </div>
            <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
                <span class="carousel-control-prev-icon carousel-control-icon" aria-hidden="true"></span>
                <span class="sr-only">Previous</span>
            </a>
            <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
                <span class="carousel-control-next-icon carousel-control-icon" aria-hidden="true"></span>
                <span class="sr-only">Next</span>
            </a>
        </div>
    </div>
</div>
