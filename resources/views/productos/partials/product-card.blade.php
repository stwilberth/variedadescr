<div class="row">
    @foreach ($productos as $producto)
        @php
            $msj_whatsapp = 'Me interesa este articulo.';
        @endphp
        <div class="col-6 col-md-2 mt-5 product-item">
            <div class="card h-100 shadow-sm">
                <a href="{{ route('productoShow', [$producto->catalogoM->slug, $producto->slug]) }}"
                    class="text-decoration-none">
                    @if ($producto->imagenes->isNotEmpty())
                        <img src="{{ asset('storage/productos/' . $producto->imagenes[0]->ruta) }}"
                            class="card-img-top" alt="{{ $producto->nombre }}"
                            loading="lazy">
                    @endif
                </a>
                <div class="card-body d-flex flex-column">
                    <h5 class="card-title text-center fs-6">
                        <a href="{{ route('productoShow', [$producto->catalogoM->slug, $producto->slug]) }}"
                            class="text-decoration-none text-dark">
                            {{ $producto->nombre }}
                        </a>
                    </h5>
                    <div class="mt-auto">
                        <p class="card-text text-center mb-0">
                            @if ($producto->oferta > 0)
                                <span class="text-decoration-line-through text-muted">
                                    ₡{{ number_format($producto->precio_venta, 0, ',', '.') }}
                                </span>
                                <br>
                                <span class="text-danger fw-bold">
                                    ₡{{ number_format($producto->precio_venta - ($producto->precio_venta * $producto->oferta) / 100, 0, ',', '.') }}
                                </span>
                            @else
                                <span class="text-success fw-bold">
                                    ₡{{ number_format($producto->precio_venta, 0, ',', '.') }}
                                </span>
                            @endif
                        </p>
                        <div class="d-flex justify-content-center gap-2 mt-2">
                            <a href="{{ route('productoShow', [$producto->catalogoM->slug, $producto->slug]) }}"
                                class="btn btn-sm btn-outline-success">
                                <i class="fas fa-eye"></i>
                            </a>
                            <a href="https://wa.me/50687181265?text={{ urlencode($msj_whatsapp) }}"
                                target="_blank" class="btn btn-sm btn-success">
                                <i class="fab fa-whatsapp"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endforeach
</div>
