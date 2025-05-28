<?php

namespace anuncielo\Http\Middleware;

use Closure;

class Cors
{
    protected $allowedOrigins = [
        'http://localhost:3000', // Tu app Nuxt en desarrollo
        'http://192.168.1.100:3000', // Otra IP local si usas red
        'https://invictacostarica.com', // Tu dominio en producción
        'http://invictacostarica.com', // Tu dominio en producción sin https
        'http://localhost:4321', // Otra IP local si usas red
        'http://variedadescr.com', // Dominio de la API
        'https://variedadescr.com', // Dominio de la API con https
        'https://fossilcostarica.com', // Dominio de la API
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