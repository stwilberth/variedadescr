<?php

namespace anuncielo\Http\Controllers;
use anuncielo\Producto;
use Illuminate\Support\Facades\Cache;
use anuncielo\Services\CacheKeys;
use Illuminate\Http\Request; 
use DB;

class Welcome extends Controller {
    public function vista()
    {
        // Cachear productos Fossil por 1 hora
        $fossil = Cache::remember(CacheKeys::welcomeKey(66), 60, function () {
            return Producto::thumbnail(1)
                ->marca(66)
                ->limit(6)
                ->get();
        });

        // Cachear productos Nixon por 1 hora
        $nixon = Cache::remember(CacheKeys::welcomeKey(63), 60, function () {
            return Producto::thumbnail(1)
                ->marca(63)
                ->limit(6)
                ->get();
        });

        // Cachear productos Invicta por 1 hora
        $invicta = Cache::remember(CacheKeys::welcomeKey(67), 60, function () {
            return Producto::thumbnail(1)
                ->marca(67)
                ->limit(6)
                ->get();
        });

        // Cachear productos en oferta por 1 hora
        $ofertas = Cache::remember(CacheKeys::welcomeKey(), 60, function () {
            return Producto::thumbnail(1)
                ->whereIn('oferta', ['1', '2'])
                ->limit(6)
                ->get();
        });

        return view('welcome', compact('fossil', 'nixon', 'invicta', 'ofertas'));
    }
}