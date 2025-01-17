<div class="d-flex justify-content-center align-items-center">
    <form action="{{ route('subscribe') }}" method="POST" class="p-4 border rounded bg-light" style="max-width: 400px; width: 100%;">
        @csrf
        <div class="form-group">
            <input type="email" name="email" id="email" class="form-control" placeholder="email" required>
        </div>
        <button type="submit" class="btn btn-success btn-block mt-3">Suscribirse</button>
    </form>
</div>
