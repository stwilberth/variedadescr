@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card mb-4">
                <div class="card-header">Configurar Dispositivo de Prueba</div>
                <div class="card-body">
                    <notification-permission></notification-permission>
                </div>
            </div>

            <div class="card">
                <div class="card-header">Enviar Notificación de Prueba</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('fcm.send') }}" class="mb-3">
                        @csrf
                        <div class="form-group mb-3">
                            <label for="title">Título</label>
                            <input type="text" class="form-control" id="title" name="title" required>
                        </div>
                        <div class="form-group mb-3">
                            <label for="body">Mensaje</label>
                            <textarea class="form-control" id="body" name="body" rows="3" required></textarea>
                        </div>
                        <div class="form-group mb-3">
                            <label for="topic">Tema</label>
                            <input type="text" class="form-control" id="topic" name="topic" value="all" required>
                        </div>
                        <button type="submit" class="btn btn-primary">Enviar Notificación</button>
                    </form>

                    @if(session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif

                    @if(session('error'))
                        <div class="alert alert-danger">
                            {{ session('error') }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
