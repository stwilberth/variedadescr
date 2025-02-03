@extends('layouts.app')
@section('meta_tags')
    <x-meta-ttags 
        :title="$title" 
        :description="$title . ' ✓ Marcas originales ✓ Precios mayoristas ✓ Envíos a todo Costa Rica'" 
        :image="isset($productos[0]->imagenes[0]) ? 'https://variedadescr.com/storage/productos/'.$productos[0]->imagenes[0]->ruta : null" 
        publishedTime="2019-01-01" 
        :section="$title" 
        :schema="[
            '@context' => 'https://schema.org',
            '@type' => 'Product',
            'name' => $title,
            'description' => $title . ' ✓ Marcas originales ✓ Precios mayoristas ✓ Envíos a todo Costa Rica',
            'image' => isset($productos[0]->imagenes[0]) ? 'https://variedadescr.com/storage/productos/'.$productos[0]->imagenes[0]->ruta : null,
            'sku' => 'SKU-123456',
            'brand' => 'VariedadesCR',
            'offers' => [
                '@type' => 'Offer',
                'price' => '100.00',
                'priceCurrency' => 'CRC',
                'availability' => 'https://schema.org/InStock'
            ]
        ]" />
@endsection
@section('content')

    @php
        $revendedor = auth()->user() && auth()->user()->AutorizaRoles('revendedor');
    @endphp

    <div class="container">
        {{-- Botón para colapsar filtros --}}
        <div class="d-flex justify-content-center mb-3">
            <button class="btn btn-outline-success" type="button" data-bs-toggle="collapse" data-bs-target="#filtrosCollapse"
                aria-expanded="true" aria-controls="filtrosCollapse">
                <i class="fas fa-filter"></i> Mostrar/Ocultar Filtros
            </button>
        </div>


        {{-- Filtros colapsables --}}
        <div class="collapse show" id="filtrosCollapse">
            <div class="row">
                <form action="{{ route('catalogoIndex', $catalogo_slug) }}" method="GET" class="col-12">
                    <div class="row mb-3">
                        {{-- Filtro Marcas --}}
                        <div class="col-12 col-sm-6 col-md-2 mb-2">
                            <select class="form-select" name="marca">
                                <option value="0">Marcas</option>
                                @foreach ($marcas as $item)
                                        <option value="{{ $item->id }}"
                                            @if ($marca_id == $item->id) selected @endif>
                                            {{ $item->nombre }}
                                        </option>
                                @endforeach
                            </select>
                        </div>
                        {{-- Filtro Género --}}
                        <div class="col-12 col-sm-6 col-md-2 mb-2">
                            <select class="form-select" name="genero">
                                @foreach (config('options.generos') as $item)
                                    <option value="{{ $item['value'] }}" @if ($item['value'] == $genero) selected @endif>
                                        {{ $item['nombre'] }}</option>
                                @endforeach
                            </select>
                        </div>
                        {{-- Filtro Orden --}}
                        <div class="col-12 col-sm-6 col-md-2 mb-2">
                            <select class="form-select" name="orden">
                                <option value="">Orden por fecha</option>
                                <option value="asc" @if (request('orden') == 'asc') selected @endif>Menor precio</option>
                                <option value="desc" @if (request('orden') == 'desc') selected @endif>Mayor precio </option>
                            </select>
                        </div>
                        {{-- Filtro Liquidación --}}
                        <div class="col-12 col-sm-6 col-md-4 mb-2">
                            <select class="form-select" name="descuento">
                                <option value="0">Todos los productos</option>
                                <option value="1" @if (request('descuento') == '1') selected @endif>En oferta</option>
                                <option value="2" @if (request('descuento') == '2') selected @endif>En liquidación
                                </option>
                            </select>
                        </div>
                        {{-- Botón Filtrar --}}
                        <div class="col-12 col-sm-6 col-md-2 mb-2">
                            <div class="d-flex justify-content-between gap-2">
                                <button type="submit" class="btn btn-success w-100">Filtrar</button>
                                <a href="{{ route('catalogoIndex', $catalogo_slug) }}" class="btn btn-outline-success w-100">Limpiar</a>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        @if (session('status'))
            <div class="alert alert-success alert-dismissible fade show mt-2" role="alert">
                {{ session('status') }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @endif

        {{-- sin resultados --}}
        @if (count($productos) <= 0)
            <div class="row">
                <div class="col-12">
                    <div class="row d-flex justify-content-center">
                        <div class="alert alert-warning alert-dismissible fade show mt-2" role="alert">
                            La consulta no generó resultados.
                        </div>
                    </div>
                </div>
            </div>
        @else
            <div class="row">
                {{-- $title --}}
                <div class="col-12">
                    <h1 class="text-center text-success fw-bold fs-2 logo-text mt-4">{{ $title }}</h1>
                </div>

                <div id="products-container">
                    @include('productos.partials.product-card', ['productos' => $productos])
                </div>

                <div id="loading-spinner" class="col-12 text-center d-none my-4">
                    <div class="spinner-border text-success" role="status">
                        <span class="visually-hidden">Cargando...</span>
                    </div>
                </div>
            </div>
        @endif
    </div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Variables globales
        const container = document.getElementById('products-container');
        const spinner = document.getElementById('loading-spinner');
        let nextPage = '{{ $productos->nextPageUrl() }}';
        let loading = false;

        // Log inicial
        console.log('Inicializando scroll infinito');
        console.log('URL siguiente página:', nextPage);
        console.log('Total productos:', {{ $productos->total() }});
        console.log('Productos por página:', {{ $productos->perPage() }});
        console.log('Página actual:', {{ $productos->currentPage() }});

        // Función para cargar más productos
        function loadMoreProducts() {
            if (loading || !nextPage) {
                console.log('No se cargan más productos:', { loading, nextPage });
                return;
            }

            console.log('Iniciando carga de productos desde:', nextPage);
            loading = true;
            spinner.classList.remove('d-none');

            // Realizar la petición AJAX
            fetch(nextPage, {
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
            .then(response => {
                console.log('Respuesta recibida:', response.status);
                return response.json();
            })
            .then(data => {
                console.log('Datos recibidos:', data);
                
                if (data.html) {
                    container.insertAdjacentHTML('beforeend', data.html);
                    console.log('HTML insertado en el contenedor');
                }
                
                nextPage = data.nextPage;
                console.log('Nueva URL siguiente página:', nextPage);
            })
            .catch(error => {
                console.error('Error en la petición:', error);
            })
            .finally(() => {
                loading = false;
                spinner.classList.add('d-none');
            });
        }

        // Función para verificar si el elemento está visible
        function isElementInViewport(el, offset = 0) {
            const rect = el.getBoundingClientRect();
            return (
                rect.bottom <= (window.innerHeight + offset) &&
                rect.right <= (window.innerWidth || document.documentElement.clientWidth)
            );
        }

        // Función para verificar scroll
        function checkScroll() {
            // Obtener el último producto del contenedor
            const products = container.querySelectorAll('.col-6');
            if (products.length === 0) return;

            const lastProduct = products[products.length - 1];
            const offset = 300; // Píxeles antes de llegar al último producto

            console.log('Verificando scroll:', {
                'Último producto visible': isElementInViewport(lastProduct, offset),
                'Distancia al viewport': lastProduct.getBoundingClientRect().bottom - window.innerHeight
            });

            if (isElementInViewport(lastProduct, offset)) {
                console.log('Último producto visible, cargando más...');
                loadMoreProducts();
            }
        }

        // Agregar evento de scroll con throttling
        let scrollTimeout;
        window.addEventListener('scroll', function() {
            if (scrollTimeout) {
                clearTimeout(scrollTimeout);
            }
            scrollTimeout = setTimeout(checkScroll, 100);
        });

        // Verificar scroll inicial
        setTimeout(checkScroll, 500);

        // Log cuando se aplican filtros
        document.querySelectorAll('form select').forEach(select => {
            select.addEventListener('change', function() {
                console.log('Filtro cambiado:', this.name, 'valor:', this.value);
                this.closest('form').submit();
            });
        });
    });
</script>
@endpush
