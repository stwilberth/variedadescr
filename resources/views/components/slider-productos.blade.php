@if (isset($products) && $products->count() > 5)
    <h2 class="fs-4 fw-bold rounded-1" style="color: var(--bs-green)">
        {{ $titulo }}
    </h2>
    <hr>

    <div class="container mb-5">
        <swiper-container 
            :breakpoints="{
                320: {
                    slidesPerView: 2,
                    spaceBetween: 10
                },
                576: {
                    slidesPerView: 3,
                    spaceBetween: 10
                },
                768: {
                    slidesPerView: 4,
                    spaceBetween: 10
                },
                992: {
                    slidesPerView: 5,
                    spaceBetween: 10
                },
                1200: {
                    slidesPerView: 6,
                    spaceBetween: 10
                }
            }"
            direction="horizontal"
            :navigation="true">
            @foreach ($products as $producto)
                <swiper-slide>
                    <h5 class="text-center text-truncate fs-6" style="color: var(--bs-gray-600)">
                        {{ $producto->nombre }}
                    </h5>
                    <a href="/catalogo/relojes/{{ $producto->slug }}">
                        @if ($producto->imagenes->count() > 0)
                            <img src="/storage/productos/thumb_{{ $producto->imagenes->first()->ruta }}"
                                class="img-responsive img-fluid" alt="Fotografia de {{ $producto->nombre }}">
                        @else
                            <img src="/img/sin_foto.png" class="card-img-top" alt="Producto sin imagen">
                        @endif
                    </a>
                    <h5 class="text-center" style="color: var(--bs-gray-600)">
                        ¢{{ number_format($producto->precio_venta, 0, ',', '.') }}
                    </h5>
                </swiper-slide>
            @endforeach

            <!-- Navegación -->
            <div slot="button-prev"></div>
            <div slot="button-next"></div>
        </swiper-container>
    </div>
@endif
