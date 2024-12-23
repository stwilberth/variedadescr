<?php

namespace anuncielo\Http\Controllers;

use anuncielo\Marca;
use Illuminate\Http\Request;
use anuncielo\ImagenMarca;
use DB;

class MarcaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $relojes = Marca::where('catalogo', 1)
            ->orderBy('nombre', 'asc')
            ->get();
        $perfumes = Marca::where('catalogo', 2)
            ->orderBy('nombre', 'asc')
            ->get();
        $catalogo = DB::table('catalogo')
            ->orderBy('nombre', 'asc')
            ->get();

        return view('marcas.index', compact('relojes', 'perfumes', 'catalogo')); 
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $marca = new Marca;
        $marca->nombre = $request->nombre;
        $marca->peso = 0;
        $marca->catalogo = $request->catalogo;
        $marca->save();
        return redirect('marcas')->with('status', 'Producto guardado correctamente.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \anuncielo\Marca  $marca
     * @return \Illuminate\Http\Response
     */
    public function show(Marca $marca)
    {
        //get marca
        $marca = Marca::where('id', $marca->id)->firstOrFail();
        //render vista
        return view('marcas.show', compact('marca'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \anuncielo\Marca  $marca
     * @return \Illuminate\Http\Response
     */
    public function edit(Marca $marca)
    {
        //get marca
        $marca = Marca::where('id', $marca->id)->firstOrFail();
        $catalogo = DB::table('catalogo')
        ->orderBy('nombre', 'asc')
        ->get();

        //render vista
        return view('marcas.edit', compact('marca', 'catalogo'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \anuncielo\Marca  $marca
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Marca $marca)
    {
        //si no tine nombre
        if(!$request->nombre){
            return back()->with('error', 'Debe ingresar un nombre.');
        }
        $marca->nombre = $request->nombre;
        $marca->save();

        //redireccionar a ruta show
        return redirect('marcas')->with('status', 'Marca guardada correctamente.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \anuncielo\Marca  $marca
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $marca = Marca::where('id', $id)->firstOrFail();

        //no se puede eliminar porque tiene productos
        if($marca->productos->count() > 0){
            return back()->with('error', 'No se puede eliminar porque tiene productos asociados.');
        }

        $marca->delete();
        return redirect('marcas')->with('status', 'Eliminado correctamente.');
    }
}
