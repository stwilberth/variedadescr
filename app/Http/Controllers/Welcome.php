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
            ->with('catalogoM')
            ->get();

        $ofertas = Producto::thumbnail(1)
            ->whereIn('oferta', ['1', '2'])
            ->with('imagenes')
            ->get();

        return view('welcome', compact('fossil', 'nixon', 'invicta', 'ofertas'));
    }
}