@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <div class="row justify-content-center">
        {{-- eliminar subscripcion --}}
        <div class="row justify-content-center mt-4">
            <div class="col-md-8">
                <div class="card border-danger">
                    <div class="card-header bg-danger text-white">
                        <h5 class="mb-0">¿Estás seguro que deseas cancelar tu suscripción? 
                            <i class="fas fa-frown-open"></i>
                         </h5> 
                    </div>
                    <div class="card-body text-center">
                        <p class="text-danger mb-4">{{ $subscriber->email }}</p>
                        <form action="{{ route('subscriptionsDestroy', $subscriber->id) }}" method="POST" onsubmit="return confirm('¿Estás seguro de eliminar tu suscripción?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">
                                <i class="fas fa-trash-alt me-2"></i>Sí
                            </button>
                            <a href="{{ route('home') }}" class="btn btn-secondary">
                                <i class="fas fa-times me-2"></i>No
                            </a>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
