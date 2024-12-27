@extends('layouts.app')
@section('content')
    <div class="container">
        <form method="POST" action="/producto-update/{{ $producto->slug }}" enctype="multipart/form-data">
            @csrf
            <div class="row mt-5">

                {{-- nombre --}}
                <div class="form-group col-6">
                    <label for="nombre">*Nombre:</label>
                    <input type="text" class="form-control" name="nombre" id="nombre" value="{{ $producto->nombre }}">
                </div>

                {{-- modelo --}}
                <div class="form-group col-6">
                    <label for="modelo">*Modelo:</label>
                    <input type="text" class="form-control" name="modelo" id="modelo"
                        value="{{ $producto->modelo }}">
                </div>

                {{-- marca --}}
                <div class="col-6">
                    <label for="marca">Marca</label>
                    <select name="marca" id="marca" class="form-control" required>
                        <option value="">Selecciona una marca</option>
                        @foreach ($marcas as $item)
                            <option value="{{ $item->id }}" @if ($item->id == $producto->marca_id) selected @endif>
                                {{ $item->catalogoM->nombre }} - {{ $item->nombre }}
                            </option>
                        @endforeach
                    </select>
                </div>

                {{-- disponibilidad --}}
                <div class="col-6">
                    <label for="disponibilidad">Disponibilidad</label>
                    <select name="disponibilidad" id="disponibilidad" class="form-control" required>
                        <option value="1" @if ($producto->disponibilidad == 1) selected @endif>Inmediata</option>
                        <option value="2" @if ($producto->disponibilidad == 2) selected @endif>Una semana</option>
                        <option value="3" @if ($producto->disponibilidad == 3) selected @endif>Dos semanas
                        </option>
                        <option value="4" @if ($producto->disponibilidad == 4) selected @endif>Agotado</option>
                    </select>
                </div>

                {{-- stock --}}
                <div class="form-group col-md-6">
                    <label for="stock">*Stock:</label>
                    <input type="text" class="form-control" id="stock" name="stock" value="{{ $producto->stock }}">
                </div>

                {{-- costo --}}
                <div class="form-group col-md-6">
                    <label for="costo">*Costo:</label>
                    <input type="text" class="form-control" id="costo" name="costo" value="{{ $producto->costo }}">
                </div>

                {{-- precio venta --}}
                <div class="form-group col-md-6">
                    <label for="precio_venta">*Precio Venta:</label>
                    <input type="text" class="form-control" id="precio_venta" name="precio_venta"
                        value="{{ $producto->precio_venta }}">
                </div>

                {{-- precio mayorista --}}
                <div class="form-group col-md-6">
                    <label for="precio_mayorista">*Precio Mayorista:</label>
                    <input type="text" class="form-control" id="precio_mayorista" name="precio_mayorista"
                        value="{{ $producto->precio_mayorista }}">
                </div>

                {{-- precio anterior --}}
                <div class="form-group col-md-6">
                    <label for="precio_anterior">Precio Anterior:</label>
                    <input type="text" class="form-control" id="precio_anterior" name="precio_anterior"
                        value="{{ $producto->precio_anterior }}">
                </div>

                {{-- precio sugerido --}}
                <div class="form-group col-md-6">
                    <label for="precio_sugerido">Precio Sugerido:</label>
                    <input type="text" class="form-control" id="precio_sugerido" name="precio_sugerido"
                        value="{{ $producto->precio_sugerido }}">
                </div>

                {{-- oferta --}}
                <div class="form-group col-md-6">
                    <label for="oferta">Tipo de oferta:</label>
                    <select class="form-control" id="oferta" name="oferta">
                        <option value="0" {{ $producto->oferta == 0 ? 'selected' : '' }}>Sin oferta</option>
                        <option value="1" {{ $producto->oferta == 1 ? 'selected' : '' }}>Oferta</option>
                        <option value="2" {{ $producto->oferta == 2 ? 'selected' : '' }}>Liquidación</option>
                    </select>
                </div>

                {{-- genero --}}
                <div class="form-group col-3">
                    <label for="genero">Género</label>
                    <select name="genero" id="genero" class="form-control">
                        <option value="1" @if ($producto->genero == 2) selected @endif>Mujer</option>
                        <option value="2" @if ($producto->genero == 1) selected @endif>Hombre</option>
                        <option value="3" @if ($producto->genero == 3) selected @endif>Unisex</option>
                    </select>
                </div>

                {{-- publicado --}}
                <div class="form-group col-3">
                    <label class="form-label">Estado</label>
                    <div class="form-check">
                        <input type="checkbox" class="form-check-input" name="publicado" id="publicado"
                            {{ $producto->publicado == 1 ? 'checked' : '' }} value="1">
                        <label class="form-check-label" for="publicado">Publicado</label>
                    </div>
                </div>


            </div>

            <div class="row">
                {{-- descripcion --}}
                <div class="col-md-12">
                    <div class="form-group">
                        <label>*Descripción:</label>
                        <textarea name="descripcion" id="descripcion" class="form-control" rows="3">{{ $producto->descripcion }}</textarea>
                    </div>
                </div>
            </div>

            <div class="row">
                {{-- descripcion redes sociales --}}
                <div class="col-md-12">
                    <div class="form-group">
                        <label>*Descripción Redes sociales:</label>
                        <textarea name="descripcion_social" id="descripcion_social" class="form-control" rows="2" maxlength="125">{{ $producto->descripcion_social }}</textarea>
                        <em> Texto simple 125 carácteres máximo</em>
                    </div>
                </div>

                {{-- tiktok --}}
                <div class="col-md-12">
                    <div class="form-group">
                        <label for="url_tiktok">Tiktok Video</label>
                        <textarea type="text" id="url_tiktok" name="url_tiktok" class="form-control" rows="2">
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
