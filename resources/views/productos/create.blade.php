@extends('layouts.app')
@section('content')
    <div class="container mt-5">
        <h1>Crear un producto</h1>
        <form method="POST" action="/producto-store" enctype="multipart/form-data">
            @csrf
            <!-------------Inputs--------------------->
            @if ($errors->any())
                <div class="row">
                    <div class="alert alert-danger" role="alert">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            @endif
            <div class="row mt-5">
                <div class="col-md-6">
                    <div class="row">

                        <div class="form-group col-md-12">
                            @php
                                $isInvalid = $errors->first('nombre') ? 'is-invalid' : '';
                            @endphp
                            <label for="nombre">*Nombre:</label>
                            <input type="text" class="form-control {{ $isInvalid }}" name="nombre" id="nombre"
                                value="{{ old('nombre') }}" required>
                            {!! $errors->first('nombre', '<div class="invalid-feedback">:message</div>') !!}
                        </div>

                        <catalogo-c marcas-lista="{{ json_encode($marcas) }}" catalogo-lista="{{ json_encode($catalogo) }}"
                            marca-selected="{{ old('marca') }}" modelo-selected="{{ old('modelo') }}"
                            catalogo-selected="{{ old('catalogo') }}">
                        </catalogo-c>

                        <genero-c></genero-c>

                        <div class="form-group col-md-6">
                            @php
                                $isInvalid = $errors->first('stock') ? 'is-invalid' : '';
                            @endphp
                            <label for="stock">*Stock:</label>
                            <input type="number" class="form-control {{ $isInvalid }}" id="stock" name="stock"
                                value="{{ old('stock') }}" required>
                            {!! $errors->first('stock', '<div class="invalid-feedback">:message</div>') !!}
                        </div>

                        <div class="form-group col-md-6">
                            @php
                                $isInvalid = $errors->first('disponibilidad') ? 'is-invalid' : '';
                            @endphp
                            <label for="disponibilidad">*Disponibilidad:</label>
                            <select class="custom-select {{ $isInvalid }}" name="disponibilidad" id="disponibilidad">
                                <option selected value="1">Inmediata</option>
                                <option value="2">Una semana</option>
                                <option value="3">Dos semanas</option>
                                <option value="4">Agotado</option>
                            </select>
                            {!! $errors->first('disponibilidad', '<div class="invalid-feedback">:message</div>') !!}
                        </div>

                        <div class="form-group col-md-6">
                            @php
                                $isInvalid = $errors->first('codigo') ? 'is-invalid' : '';
                            @endphp
                            <label for="codigo">Código:</label>
                            <input type="text" class="form-control {{ $isInvalid }}" id="codigo" name="codigo"
                                value="{{ old('codigo') }}">
                            {!! $errors->first('codigo', '<div class="invalid-feedback">:message</div>') !!}
                        </div>

                    </div>
                </div>
                <div class="col-md-6">
                    <div class="row">
                        <div class="form-group col-md-6">
                            @php
                                $isInvalid = $errors->first('moneda') ? 'is-invalid' : '';
                            @endphp
                            <label for="moneda">*Moneda:</label>
                            <select class="custom-select {{ $isInvalid }}" name="moneda" id="moneda" required>
                                <option value="1">¢</option>
                                <option value="2">$</option>
                            </select>
                            {!! $errors->first('moneda', '<div class="invalid-feedback">:message</div>') !!}

                        </div>
                        <div class="form-group col-md-6">
                            @php
                                $isInvalid = $errors->first('costo') ? 'is-invalid' : '';
                            @endphp
                            <label for="costo">*Costo:</label>
                            <input type="number" class="form-control {{ $isInvalid }}" id="costo" name="costo"
                                value="{{ old('costo') }}" required>
                            {!! $errors->first('costo', '<div class="invalid-feedback">:message</div>') !!}

                        </div>
                        <div class="form-group col-md-6">
                            @php
                                $isInvalid = $errors->first('precio_mayorista') ? 'is-invalid' : '';
                            @endphp
                            <label for="precio_venta">*Precio Mayorista:</label>
                            <input type="number" class="form-control {{ $isInvalid }}" id="precio_mayorista"
                                name="precio_mayorista" value="{{ old('precio_mayorista') }}" required>
                            {!! $errors->first('precio_mayorista', '<div class="invalid-feedback">:message</div>') !!}
                        </div>
                        <div class="form-group col-md-6">
                            @php
                                $isInvalid = $errors->first('precio_venta') ? 'is-invalid' : '';
                            @endphp
                            <label for="precio_venta">*Precio Venta:</label>
                            <input type="number" class="form-control {{ $isInvalid }}" id="precio_venta"
                                name="precio_venta" value="{{ old('precio_venta') }}" required>
                            {!! $errors->first('precio_venta', '<div class="invalid-feedback">:message</div>') !!}
                        </div>
                        <div class="form-group col-md-6">
                            <label for="descuento">Descuento:</label>
                            <input type="number" class="form-control" id="descuento" name="descuento"
                                value="{{ old('descuento') }}">
                            {!! $errors->first('descuento', '<div class="invalid-feedback">:message</div>') !!}
                        </div>

                        <div class="form-group col-md-6">
                            <label for="precio_anterior">Precio Anterior:</label>
                            <input type="number" class="form-control" id="precio_anterior" name="precio_anterior"
                                value="{{ old('precio_anterior') }}">
                            {!! $errors->first('precio_anterior', '<div class="invalid-feedback">:message</div>') !!}
                        </div>

                        <div class="form-group col-md-6">
                            <label for="precio_sugerido">Precio Sugerido:</label>
                            <input type="number" class="form-control" id="precio_sugerido" name="precio_sugerido"
                                value="{{ old('precio_sugerido') }}">
                            {!! $errors->first('precio_sugerido', '<div class="invalid-feedback">:message</div>') !!}
                        </div>

                        {{-- tipo de descuento --}}
                        <div class="form-group col-md-6">
                            <label for="oferta">Tipo de oferta:</label>
                            <select class="custom-select" id="oferta" name="oferta">
                                <option value="0">Sin oferta</option>
                                <option value="1">Oferta</option>
                                <option value="2">Liquidación</option>
                            </select>
                        </div>

                        <div class="form-group col-md-3">
                            <div class="checkbox" v-show="false">
                                <label>
                                    <input type="checkbox" id="destacado" name="destacado"> Destacado
                                </label>
                            </div>
                        </div>

                        <div class="form-group col-md-3">
                            <div class="checkbox">
                                <label>
                                    <input type="checkbox" checked name="publicado"> Publicado
                                </label>
                            </div>
                        </div>

                        <div class="checkbox col-md-3" style="margin-bottom:10px" v-show="false">
                            <label>
                                <input type="checkbox" name="oferta" id="oferta" value="false"
                                    v-model="reloj_create.oferta" v-show="false"> Es oferta.
                            </label>
                        </div>


                        <div class="form-group col-md-6" v-show="reloj_create.oferta">
                            <label for="fecha_inicio">Inicio de la oferta:</label>
                            <input type="datetime-local" class="form-control" id="fecha_inicio" name="fecha_inicio">
                        </div>
                        <div class="form-group col-md-6" v-show="reloj_create.oferta">
                            <label for="fecha_fin">Fin de la oferta:</label>
                            <input type="datetime-local" class="form-control" id="fecha_fin" name="fecha_fin">
                        </div>

                    </div>
                </div>
            </div>
            <!-------------Inputs fin--------------------->






            <!-------------Descripcion--------------------->
            <div class="row">
                <div class="col-md-12">
                    <div class="form-group">
                        @php
                            $isInvalid = $errors->first('descripcion') ? 'is-invalid' : '';
                        @endphp
                        <label>*Descripción:</label>
                        <textarea name="descripcion" id="descripcion" class="form-control {{ $isInvalid }}" rows="3">{{ old('descripcion') }}</textarea>
                        {!! $errors->first('descripcion', '<div class="invalid-feedback">:message</div>') !!}
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="form-group">
                        @php
                            $isInvalid = $errors->first('descripcion_social') ? 'is-invalid' : '';
                        @endphp
                        <label>*Descripción Redes sociales:</label>
                        <textarea name="descripcion_social" id="descripcion_social" class="form-control {{ $isInvalid }}" rows="2"
                            maxlength="125" required>{{ old('descripcion_social') }}</textarea>
                        <em> Texto simple 125 carácteres máximo</em>
                        {!! $errors->first('descripcion_social', '<div class="invalid-feedback">:message</div>') !!}
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="form-group">
                        <label for="url_tiktok">Tiktok Video</label>
                        <textarea type="text" id="url_tiktok" name="url_tiktok" class="form-control" rows="6">
                                                {{ old('url_tiktok') }}
                                        </textarea>
                    </div>
                </div>
            </div>
            <!-------------Descripcion fin--------------------->


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
