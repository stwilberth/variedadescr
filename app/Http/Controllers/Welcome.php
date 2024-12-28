<?php

namespace anuncielo\Http\Controllers;
use anuncielo\Producto;
use Illuminate\Http\Request; 
use DB;

class Welcome extends Controller {
    public function vista()
    {
        $fossil = Producto::thumbnail(1)
            ->marca(66)
            ->with('imagenes')
            ->get();

        $nixon = Producto::thumbnail(1)
            ->marca(63)
            ->with('imagenes')
            ->get();

        $invicta = Producto::thumbnail(1)
            ->marca(67)
            ->with('imagenes')
            ->get();

        $ofertas = Producto::thumbnail(1)
            ->withoutGlobalScope('oferta')
            ->whereIn('oferta', ['1', '2'])
            ->with('imagenes')
            ->get();

        return view('welcome', compact('fossil', 'nixon', 'invicta', 'ofertas'));
    }
}