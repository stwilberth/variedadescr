<?php

namespace App\Http\Middleware;

use Closure;

class Cors
{
    protected $allowedOrigins = [
        'http://localhost:3000', // Tu app Nuxt en desarrollo
        'http://192.168.1.100:3000', // Otra IP local si usas red
        'https://invictacostarica.com', // Tu dominio en producción
    ];

    public function handle($request, Closure $next)
    {
        $origin = $request->header('Origin');

        if (in_array($origin, $this->allowedOrigins)) {
            return $next($request)
                ->header('Access-Control-Allow-Origin', $origin)
                ->header('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, OPTIONS')
                ->header('Access-Control-Allow-Headers', 'Content-Type, Authorization');
        }

        // Si el origen no está permitido, devolvemos el siguiente middleware sin CORS
        return $next($request);
    }
}