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
            ->publicado()
            ->get();

        $title = $Catalogo->nombre . ' '.$marca_nombre . ' ' . $genero_name;

        return view('productos.index', compact('productos', 'marca_id', 'genero', 'marcas', 'catalogo_slug', 'title'));
    }

    public function create(Request $request)
    {
        $marcas = Marca::orderBy('nombre', 'asc')->get();
        $catalogo = Catalogo::orderBy('nombre', 'asc')->get();
        return view('productos.create', compact('marcas', 'catalogo'));
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
            $producto->catalogo = $request->catalogo;
            $producto->destacado = ($request->destacado)?1:0;
            $producto->slider = null;
            $producto->publicado = ($request->publicado)?1:0;
            $producto->oferta = $request->oferta;
            $producto->fecha_inicio = ($request->fecha_inicio);
            $producto->fecha_fin = $request->fecha_fin;
            $producto->moneda = $request->moneda;
            $producto->costo = $request->costo;
            $producto->precio_venta = $request->precio_venta;
            $producto->precio_mayorista = $request->precio_mayorista;
            $producto->descuento = $request->descuento;
            $producto->precio_sugerido = $request->precio_sugerido;
            $producto->codigo = $request->codigo;
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
            ->marca(66)
            ->catalogo(1)
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
        $marcas = Marca::orderBy('peso', 'asc')->get();
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
            $producto->nuevo = 1;
            $producto->catalogo = $request->catalogo;
            $producto->destacado = ($request->destacado)?1:0;
            $producto->slider = null;
            $producto->publicado = ($request->publicado)?1:0;
            $producto->oferta = $request->oferta;
            $producto->fecha_inicio = ($request->fecha_inicio);
            $producto->fecha_fin = $request->fecha_fin;
            $producto->moneda = $request->moneda;
            $producto->costo = $request->costo;
            $producto->precio_venta = $request->precio_venta;
            $producto->precio_mayorista = $request->precio_mayorista;
            $producto->descuento = $request->descuento;
            $producto->precio_sugerido = $request->precio_sugerido;
            $producto->codigo = $request->codigo;
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
        return redirect('catalogo/relojes/'.$producto->slug)->with('status', 'Producto guardado correctamente.');
    }

    public function destroy($slug)
    {
        return redirect('relojes')->with('status', 'Todavia no se puede borrar productos.');

    }
    static function getProductos($disponibilidad)
    {
        $productos = Producto::orderBy('created_at', 'desc')
        ->leftJoin('catalogo', 'productos.catalogo', '=', 'catalogo.id')
        ->publicado()
        ->where('disponibilidad', $disponibilidad)
        ->select(
            'productos.id', 
            'productos.nombre', 
            'productos.costo', 
            'productos.precio_venta',
            'productos.stock',
            'productos.moneda',
            'productos.slug',
            'productos.disponibilidad',
            'productos.marca_id',
            'catalogo.slug as categoria')
        ->get();
        return $productos;
    }
    public function inventario(Request $request)
    {
        $admin = false;
        if (auth()->user() && auth()->user()->AutorizaRoles('admin')) {
            $admin = true;
            $productos = Productos::getProductos(0);
            return view('productos.inventario', compact('productos', 'admin'));
        }

         return view('errors.404');

    }
    public function inventarito(Request $request, $disponibilidad)
    {
        $admin = false;
        if ($request->user()) {
            if ($request->user()->AutorizaRoles('admin')) {
                $admin = true;
                return json_encode(
                    Productos::getProductos($disponibilidad)
                );
            } else {
                return "";
            }
        } else {
            return "";
        }
    }
    public function updateInventario(Request $request, $slug)
    {
        $admin = false;
        if ($request->user()) {
            if ($request->user()->AutorizaRoles('admin')) {
                $admin = true;
                $producto = Producto::where('slug', $slug)->firstOrFail();
                $producto->precio_venta = $request->precio_venta;
                $producto->stock = $request->stock;
                $producto->disponibilidad = (int)$request->disponibilidad;
                $producto->save();
                return json_encode($producto);
            } else {
                return "";
            }
        } else {
            return "";
        }
    }
}
