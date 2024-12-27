<?php

namespace anuncielo\Http\Controllers;
use anuncielo\Producto;
use anuncielo\Marca;
use anuncielo\Catalogo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use anuncielo\Http\Requests\productoCreate;
use anuncielo\Events\ProductoCreado;
use Image;
use DB;
use Error;

class Productos extends Controller
{

    public function index(Request $request, $catalogo_slug)
    {
        $descuento = $request->descuento;
        $marca_id = $request->marca;
        $genero = $request->genero;
        $Catalogo = Catalogo::where('slug', $catalogo_slug)->firstOrFail();
        $marcas = Marca::where('catalogo', $Catalogo->id)->orderBy('peso', 'asc')->get();
        //obtener cantidad de productos de cada marca
        foreach ($marcas as $marca) {
            $marca->cantidad = Producto::where('marca_id', $marca->id)->publicado()->count();
        }

        $marca_nombre = '';
        if ($marca_id) {
            $Marca = Marca::where('id', $marca_id)->firstOrFail();
            $marca_nombre = $Marca->nombre;
        }

        //genero title
        if ($genero == 1) {
            $genero_name = 'para Mujer';
        } elseif ($genero == 2) {
            $genero_name = 'para Hombre';
        } elseif ($genero == 3) {
            $genero_name = 'Unisex';
        } else {
            $genero_name = '';
        }

        $orden = $request->orden;

        // Modificar la consulta base para incluir el ordenamiento por precio
        $query = Producto::where('disponibilidad', '!=', 4)
            ->orderBy('publicado', 'desc');

        // Aplicar ordenamiento por precio si está especificado
        if ($orden === 'asc') {
            $query->orderBy('precio_venta', 'asc');
        } elseif ($orden === 'desc') {
            $query->orderBy('precio_venta', 'desc');
        } else {
            // Mantener el orden por defecto si no se especifica ordenamiento por precio
            $query->orderBy('created_at', 'desc')->orderBy('marca_id', 'desc');
        }

        if ($descuento) {
            $query->where('oferta', $descuento);
        }

        $productos = $query->marca($marca_id)
            ->genero($genero)
            ->catalogo($Catalogo->id)
            ->where('publicado', 1)
            ->get();

        $title = $Catalogo->nombre . ' '.$marca_nombre . ' ' . $genero_name;

        return view('productos.index', compact('productos', 'marca_id', 'genero', 'marcas', 'catalogo_slug', 'title'));
    }

    public function create(Request $request)
    {
        $marcas = Marca::orderBy('catalogo', 'asc')->orderBy('nombre', 'asc')->get();
        return view('productos.create', compact('marcas'));
    }

    public function store(productoCreate $request)
    {
        $marca = Marca::findOrFail($request->marca);

            $producto = new Producto;
            $producto->nombre = $request->nombre;
            $producto->descripcion = $request->descripcion;
            $producto->descripcion_social = $request->descripcion_social;
            $producto->genero = $request->genero;
            $producto->marca_id = $request->marca;
            $producto->modelo = $request->modelo;
            $producto->nuevo = 1;
            $producto->catalogo = $marca->catalogo;
            $producto->destacado = 0;
            $producto->slider = null;
            $producto->publicado = 1;
            $producto->oferta = $request->oferta;
            $producto->fecha_inicio = null;
            $producto->fecha_fin = null;
            $producto->moneda = 1;
            $producto->costo = $request->costo;
            $producto->precio_venta = $request->precio_venta;
            $producto->precio_mayorista = $request->precio_mayorista;
            $producto->descuento = 0;
            $producto->precio_sugerido = $request->precio_sugerido;
            $producto->codigo = null;
            $producto->stock = $request->stock;
            $producto->disponibilidad = $request->disponibilidad;
            $producto->url_tiktok = $request->url_tiktok;
            $modelo = str_replace(" ","-",$request->modelo);
            $marca_sin_espacios = str_replace(" ","-",$marca->nombre);
            $producto->slug = $marca_sin_espacios."-".$modelo;
        

        $producto->save();
        if($producto->publicado == 1){
            //event(new ProductoCreado($producto));
        }

        return redirect('image-edit/'.$producto->slug)->with('status', 'Producto guardado correctamente.');
    }

    public function show(Request $request, $categoria, $slug)
    {
        $catalogo = Catalogo::where('slug', $categoria)->firstOrFail();
        $admin = false;
        if (Auth::user() && Auth::user()->AutorizaRoles('admin')) {
            $producto = Producto::where('slug', $slug)->catalogo($catalogo->id)->firstOrFail();
            $admin = true;
        } else {
            $producto = Producto::where('slug', $slug)->catalogo($catalogo->id)->firstOrFail();
        }

        if ($catalogo->id != $producto->catalogoM->id) {
            return view('errors.404');
        }

        $more_products = Producto::orderBy('created_at', 'desc')
            ->where('id', '!=', $producto->id)
            ->marca($producto->marca_id)
            ->catalogo($producto->catalogo)
            ->publicado()
            ->get();

       
        //obtener productos nuevos con menos de 30 dias de antiguedad
        $new_products = Producto::orderBy('created_at', 'desc')
            ->where('id', '!=', $producto->id)
            ->where('created_at', '>=', date('Y-m-d', strtotime('-30 days')))
            ->publicado()
            ->get();
    
        return view('productos.show', compact('producto', 'admin', 'more_products', 'new_products')); 
    }

    public function edit(Request $request, $slug)
    {
        $producto = Producto::where('slug', $slug)->firstOrFail();
        $title = $producto->nombre;
        $catalogo = Catalogo::orderBy('peso', 'asc')->get();
        $marcas = Marca::orderBy('catalogo', 'asc')->orderBy('nombre', 'asc')->get();
        return view('productos.edit', compact('producto', 'title', 'marcas', 'catalogo'));
    }

    public function update(Request $request, $slug)
    {
        $marca = Marca::findOrFail($request->marca);
        $producto = Producto::where('slug', $slug)->firstOrFail();

            $producto->nombre = $request->nombre;
            $producto->descripcion = $request->descripcion;
            $producto->descripcion_social = $request->descripcion_social;
            $producto->genero = $request->genero;
            $producto->marca_id = $request->marca;
            $producto->modelo = $request->modelo;
            $producto->catalogo = $marca->catalogo;
            $producto->publicado = (int)$request->publicado;
            $producto->oferta = (int)$request->oferta;
            $producto->costo = $request->costo;
            $producto->precio_venta = $request->precio_venta;
            $producto->precio_mayorista = $request->precio_mayorista;
            $producto->precio_sugerido = $request->precio_sugerido;
            $producto->precio_anterior = $request->precio_anterior;
            $producto->stock = $request->stock;
            $producto->disponibilidad = $request->disponibilidad;
            $producto->url_tiktok = $request->url_tiktok;
            $modelo = str_replace(" ","-",$request->modelo);
            $marca_sin_espacios = str_replace(" ","-",$marca->nombre);
            $producto->slug = $marca_sin_espacios."-".$modelo;
        
        $producto->save();

        return redirect('catalogo/relojes/'.$producto->slug)->with('status', 'Producto guardado correctamente.');
    }

    public function destroy($slug)
    {
        return redirect('relojes')->with('status', 'Todavia no se puede borrar productos.');

    }

    public function inventario(Request $request)
    {
        $admin = false;
        if (auth()->user() && auth()->user()->AutorizaRoles('admin')) {
            $admin = true;
            $productos = Producto::where('stock', '>', 0)
                ->where('publicado', 1)
                ->orderBy('catalogo', 'asc')
                ->orderBy('stock', 'desc')
                ->orderBy('costo', 'asc')
                ->get();

            return view('productos.inventario', compact('productos', 'admin'));
        }

         return view('errors.404');

    }
}
