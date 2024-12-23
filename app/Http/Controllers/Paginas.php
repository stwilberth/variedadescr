<?php

namespace anuncielo\Http\Controllers;

use anuncielo\Http\Controllers\Controller;
use Illuminate\Http\Request;

class Paginas extends  Controller
{
    public function contactar(Request $request)
    {
        return view('paginas.contactar');
    }
    public function garantia(Request $request)
    {
        return view('paginas.garantia');
    }
    public function envio(Request $request)
    {
        return view('paginas.envio');
    }
    public function quienes_somos(Request $request)
    {
        return view('paginas.quienes_somos');
    }
}
