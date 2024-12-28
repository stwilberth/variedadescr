@extends('layouts.app')

@section('content')
    <div class="container">
        <form method="POST" action="/producto-store" enctype="multipart/form-data">
            @csrf
            @if ($errors->any())
                <x-alert type="danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </x-alert>
            @endif

            <div class="row mt-5">
                <h3>Crear producto</h3>
                <div class="col-6">
                    <x-form-field label="Nombre" name="nombre" required />
                </div>

                <div class="col-6">
                    <x-form-field label="Modelo" name="modelo" required />
                </div>

                <div class="col-6">
                    <label for="marca">Marca</label>
                    <select name="marca" id="marca" class="form-control" required>
                        <option value="">Selecciona una marca</option>
                        @foreach ($marcas as $item)
                            <option value="{{ $item->id }}">{{ $item->catalogoM->nombre }} - {{ $item->nombre }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-6">
                    <label for="disponibilidad">Disponibilidad</label>
                    <select name="disponibilidad" id="disponibilidad" class="form-control" required>
                        <option value="0">Inmediata</option>
                        <option value="1">Una semana</option>
                        <option value="2">Dos semanas</option>
                        <option value="3">Agotado</option>
                    </select>
                </div>

                <div class="col-6">
                    <x-form-field label="Stock" name="stock" type="number" required />
                </div>

                <div class="col-6">
                    <x-form-field label="Costo" name="costo" type="number" required />
                </div>
                <div class="col-6">
                    <x-form-field label="Precio Venta" name="precio_venta" type="number" required />
                </div>
                <div class="col-6">
                    <x-form-field label="Precio Mayorista" name="precio_mayorista" type="number" required />
                </div>
                <div class="col-6">
                    <x-form-field label="Precio Anterior" name="precio_anterior" type="number" />
                </div>
                <div class="col-6">
                    <x-form-field label="Precio Sugerido" name="precio_sugerido" type="number" />
                </div>

                <div class="col-6">
                    <x-form-select label="Tipo de oferta" name="oferta" :options="[
                        0 => 'Sin oferta',
                        1 => 'Oferta',
                        2 => 'Liquidación',
                    ]" />
                </div>

                <div class="col-6">
                    {{-- genero --}}
                    <x-form-select label="Genero" name="genero" :options="[
                        1 => 'Femenino',
                        2 => 'Masculino',
                        3 => 'Unisex',
                    ]" required />
                </div>
            </div>

            <div class="row mt-4">
                <div class="col-12">
                    <div class="mb-3">
                        <label for="descripcion" class="form-label">Descripción</label>
                        <textarea id="descripcion" name="descripcion">
                            {{ old('descripcion') }}
                        </textarea>
                    </div>

                    <x-form-field label="Descripción Redes sociales" name="descripcion_social" type="textarea" required
                        rows="2" maxlength="125" help="Texto simple 125 carácteres máximo" />

                    <x-form-field label="Tiktok Video" name="url_tiktok" type="textarea" rows="2" />
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
            toolbar: 'undo redo | numlist bullist bold italic underline strikethrough | indent outdent aligncenter alignjustify alignright alignleft | fontselect emoticons',
            height: 200,
        });
    </script>
@endsection
