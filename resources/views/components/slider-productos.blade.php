@if (isset($products) && $products->count() > 5)
    @php
        // sirve para hacer los productos en grupos de 4
        $groups = [];
        $gruposDe4 = [];
        $conteoDe4 = 0;
        for ($i = 0; $i < count($products); ++$i) {
            $conteoDe4 = $conteoDe4 + 1;
            if ($conteoDe4 <= 6) {
                array_push($gruposDe4, $products[$i]);
            } else {
                array_push($groups, $gruposDe4);
                $gruposDe4 = [];
                $conteoDe4 = 0;
            }
        }
        //crear id unico con timestap aleatorio para el slider y convertirlo en letras
        $sliderid = str_shuffle(strtotime('now') . rand(1, 10000));
        //convertir $sliderid en letras
        $sliderid = base_convert($sliderid, 10, 36);
    @endphp

    <h2 class="fs-4 fw-bold rounded-1"
        style="color: var(--bs-green)">
        {{ $titulo }}
    </h2>
    <hr>

    <div class="container mb-5">
        <div class="row">
            <div class="col-12">
                <div id="{{ $sliderid }}" class="carousel slide" data-bs-ride="carousel">
                    <div class="carousel-inner">
                        @php $active = 'active'; @endphp
                        @foreach ($groups as $productos)
                            <div class="carousel-item {{ $active }}">
                                <div class="row">
                                    @foreach ($productos as $producto)
                                        <div class="col-md-2">
                                            <div class="thumb-wrapper">
                                                <div class="img-box">
                                                    <h5 class="text-center text-truncate fs-6"
                                                        style="color: var(--bs-gray-600)">
                                                        {{ $producto->nombre }}</h5>
                                                    <a href="/catalogo/relojes/{{ $producto->slug }}">
                                                        @if ($producto->imagenes->count() > 0)
                                                            <img src="/storage/productos/thumb_{{ $producto->imagenes->first()->ruta }}"
                                                                class="img-responsive img-fluid"
                                                                alt="Fotografia de {{ $producto->nombre }}">
                                                        @else
                                                            <img src="/img/sin_foto.png" class="card-img-top"
                                                                alt="Producto sin imagen">
                                                        @endif
                                                    </a>
                                                    <h5 class="text-center" style="color: var(--bs-gray-600)">
                                                        ₡{{ number_format($producto->precio_venta, 0, ',', '.') }}
                                                    </h5>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                            @php $active = ''; @endphp
                        @endforeach
                    </div>
                    @if (count($groups) > 1)
                        <button class="carousel-control-prev text-dark" type="button"
                            data-bs-target="#{{ $sliderid }}" data-bs-slide="prev" style="left: -60px;">
                            <i class="fa fa-2x fa-chevron-left"></i>
                        </button>
                        <button class="carousel-control-next text-dark" type="button"
                            data-bs-target="#{{ $sliderid }}" data-bs-slide="next" style="right: -60px;">
                            <i class="fa fa-2x fa-chevron-right"></i>
                        </button>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endif
