<?php

namespace anuncielo\Http\Controllers;
use anuncielo\Producto;
use Illuminate\Http\Request; 
use DB;

class Welcome extends Controller {
    public function vista()
    {
        $fossil = Producto::orderBy('created_at', 'desc')
            ->marca(66)
            ->catalogo(1)
            ->publicado()
            ->get();

        $nixon = Producto::orderBy('created_at', 'desc')
            ->marca(63)
            ->catalogo(1)
            ->publicado()
            ->get();

        $invicta = Producto::orderBy('created_at', 'desc')
            ->marca(67)
            ->catalogo(1)
            ->publicado()
            ->get();

        $perfumes = Producto::orderBy('created_at', 'desc')
            ->catalogo(2)
            ->publicado()
            ->get();

        $ofertas = Producto::orderBy('created_at', 'desc')
            ->catalogo(1)
            ->publicado()
            ->where('oferta', '!=', '0')
            ->get();

        return view('welcome', compact('fossil', 'nixon', 'invicta', 'perfumes', 'ofertas'));
    }
}