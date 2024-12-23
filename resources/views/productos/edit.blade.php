@extends('layouts.app')
@section('content')
    <div class="container mt-5">
        <h1>Editar producto</h1>

        <form method="POST" action="/producto-update/{{ $producto->slug }}" enctype="multipart/form-data">
            @csrf
            <div class="row mt-5">
                <div class="col-md-6">
                    <div class="row">

                        <div class="form-group col-md-12">
                            <label for="nombre">*Nombre:</label>
                            <input type="text" class="form-control" name="nombre" id="nombre"
                                value="{{ $producto->nombre }}">
                        </div>

                        <catalogo-c marcas-lista="{{ json_encode($marcas) }}" catalogo-lista="{{ json_encode($catalogo) }}"
                            marca-selected="{{ $producto->marca_id }}" modelo-selected="{{ $producto->modelo }}"
                            catalogo-selected="{{ $producto->catalogo }}">
                        </catalogo-c>

                        <genero-c></genero-c>

                        <div class="form-group col-md-6">
                            <label for="stock">*Stock:</label>
                            <input type="text" class="form-control" id="stock" name="stock"
                                value="{{ $producto->stock }}">
                        </div>



                        <div class="form-group col-md-6">
                            @php
                                $disponibilidad = config('options.disponibilidad');
                                for ($i = 0; $i < count($disponibilidad); $i++) {
                                    if ($disponibilidad[$i]['value'] == $producto->disponibilidad) {
                                        $disponibilidad[$i]['selected'] = 'selected';
                                    } else {
                                        $disponibilidad[$i]['selected'] = '';
                                    }
                                }
                            @endphp
                            <label for="disponibilidad">*Disponibilidad:</label>
                            <select class="custom-select" name="disponibilidad" id="disponibilidad">
                                @foreach ($disponibilidad as $item)
                                    <option value="{{ $item['value'] }}" {{ $item['selected'] }}>{{ $item['nombre'] }}
                                    </option>
                                @endforeach
                            </select>
                        </div>



                        <div class="form-group col-md-6">
                            <label for="codigo">Código:</label>
                            <input type="text" class="form-control" id="codigo" name="codigo"
                                value="{{ $producto->codigo }}">
                        </div>

                    </div>
                </div>
                <div class="col-md-6">
                    <div class="row">
                        <div class="form-group col-md-6">
                            <label for="moneda">*Moneda:</label>
                            <select class="custom-select" name="moneda" id="moneda">
                                <option selected value="1">¢</option>
                                <option value="2">$</option>
                            </select>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="costo">*Costo:</label>
                            <input type="text" class="form-control" id="costo" name="costo"
                                value="{{ $producto->costo }}">
                        </div>
                        <div class="form-group col-md-6">
                            <label for="precio_venta">*Precio Venta:</label>
                            <input type="text" class="form-control" id="precio_venta" name="precio_venta"
                                value="{{ $producto->precio_venta }}">
                        </div>
                        <div class="form-group col-md-6">
                            <label for="precio_mayorista">*Precio Mayorista:</label>
                            <input type="text" class="form-control" id="precio_mayorista" name="precio_mayorista"
                                value="{{ $producto->precio_mayorista }}">
                        </div>
                        <div class="form-group col-md-6">
                            <label for="descuento">Descuento:</label>
                            <input type="text" class="form-control" id="descuento" name="descuento"
                                value="{{ $producto->descuento }}">
                        </div>

                        <div class="form-group col-md-6">
                            <label for="precio_anterior">Precio Anterior:</label>
                            <input type="text" class="form-control" id="precio_anterior" name="precio_anterior"
                                value="{{ $producto->precio_anterior }}">
                        </div>

                        <div class="form-group col-md-6">
                            <label for="precio_sugerido">Sugerido:</label>
                            <input type="text" class="form-control" id="precio_sugerido" name="precio_sugerido"
                                value="{{ $producto->precio_sugerido }}">
                        </div>

                        <div class="form-group col-md-3">
                            <div class="checkbox">
                                <label>
                                    <input type="checkbox" id="destacado" name="destacado"
                                        {{ $producto->destacado == 1 ? 'checked' : '' }} value="1"> Destacado
                                </label>
                            </div>
                        </div>

                        <div class="form-group col-md-3">
                            <div class="checkbox">
                                <label>
                                    <input type="checkbox" name="publicado"
                                        {{ $producto->publicado == 1 ? 'checked' : '' }} value="1"> Publicado
                                </label>
                            </div>
                        </div>

                        <div class="form-group col-md-6">
                            <label for="oferta">Tipo de oferta:</label>
                            <select class="custom-select" id="oferta" name="oferta">
                                <option value="0" {{ $producto->oferta == 0 ? 'selected' : '' }}>Sin oferta</option>
                                <option value="1" {{ $producto->oferta == 1 ? 'selected' : '' }}>Oferta</option>
                                <option value="2" {{ $producto->oferta == 2 ? 'selected' : '' }}>Liquidación</option>
                            </select>
                        </div>

                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="form-group">
                        <label>*Descripción:</label>
                        <textarea name="descripcion" id="descripcion" class="form-control" rows="3">{{ $producto->descripcion }}</textarea>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="form-group">
                        <label>*Descripción Redes sociales:</label>
                        <textarea name="descripcion_social" id="descripcion_social" class="form-control" rows="2" maxlength="125">{{ $producto->descripcion_social }}</textarea>
                        <em> Texto simple 125 carácteres máximo</em>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="form-group">
                        <label for="url_tiktok">Tiktok Video</label>
                        <textarea type="text" id="url_tiktok" name="url_tiktok" class="form-control" rows="6">
                                        {{ $producto->url_tiktok }}
                                </textarea>
                    </div>
                </div>
            </div>
            <button type="submit" class="btn btn-success mt-4">Guardar</button>
        </form>
    </div>
@endsection
@section('script')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/tinymce/6.8.3/tinymce.min.js"></script>
    <script>
        tinymce.init({
            selector: '#descripcion',
            plugins: "lists emoticons",
            menubar: false,
            toolbar: 'undo redo | numlist bullist bold italic underline strikethrough | indent outdent aligncenter alignjustify alignright alignleft | fontselect emoticons'
        });
    </script>
@endsection
