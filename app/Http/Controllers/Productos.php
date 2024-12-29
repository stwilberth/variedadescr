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
        $catalogo_id = ($catalogo_slug == 'relojes') ? 1 : 2;
        $orden = $request->orden;

        $marcas = Marca::where('catalogo', $catalogo_id)
            ->whereHas('productos', function ($query) {
                $query->where('stock', '>', 0)
                    ->where('disponibilidad', '!=', 3);
            })
            ->orderBy('nombre', 'asc')
            ->get();

        $marca_nombre = ($marca_id) ? Marca::findOrFail($marca_id)->nombre : '';

        //genero title
        $genero_name = match ($genero) {
            1 => 'para Mujer',
            2 => 'para Hombre', 
            3 => 'Unisex',
            default => ''
        };


        $productos = Producto::thumbnail($catalogo_id)
            ->marca($marca_id)
            ->genero($genero)
            ->oferta($descuento)
            ->ordenar($orden)
            ->get();

        foreach ($productos as $producto) {
            $producto->imagen = ($producto->imagenes->count() > 0) ? $producto->imagenes->first()->ruta : null;
        }


        $title = ucfirst($catalogo_slug) . ' '.$marca_nombre . ' ' . $genero_name;

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
            $producto->catalogo = $marca->catalogo;
            $producto->publicado = 1;
            $producto->oferta = $request->oferta;
            $producto->costo = $request->costo;
            $producto->precio_venta = $request->precio_venta;
            $producto->precio_mayorista = $request->precio_mayorista;
            $producto->precio_sugerido = $request->precio_sugerido;
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
            $producto = Producto::where('slug', $slug)
                ->catalogo($catalogo->id)
                ->withoutPublicado()
                ->firstOrFail();
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
            ->get();

        //obtener productos nuevos con menos de 30 dias de antiguedad
        $new_products = Producto::orderBy('created_at', 'desc')
            ->where('id', '!=', $producto->id)
            ->where('created_at', '>=', date('Y-m-d', strtotime('-30 days')))
            ->get();
    
        return view('productos.show', compact('producto', 'admin', 'more_products', 'new_products')); 
    }

    public function edit(Request $request, $slug)
    {
        $producto = Producto::where('slug', $slug)
            ->withoutPublicado()
            ->firstOrFail();
        $title = $producto->nombre;
        $catalogo = Catalogo::orderBy('peso', 'asc')->get();
        $marcas = Marca::orderBy('catalogo', 'asc')->orderBy('nombre', 'asc')->get();
        return view('productos.edit', compact('producto', 'title', 'marcas', 'catalogo'));
    }

    public function update(Request $request, $slug)
    {
        $marca = Marca::findOrFail($request->marca);
        $producto = Producto::where('slug', $slug)
            ->withoutPublicado()
            ->firstOrFail();

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
                ->where('disponibilidad', '=', 0)
                ->orderBy('catalogo', 'asc')
                ->orderBy('stock', 'desc')
                ->orderBy('costo', 'asc')
                ->get();

            return view('productos.inventario', compact('productos', 'admin'));
        }

         return view('errors.404');

    }

    public function sinPublicar(Request $request)
    {
        $productos = Producto::sinPublicar()
            ->orderBy('catalogo', 'asc')
            ->orderBy('stock', 'desc')
            ->orderBy('costo', 'asc')
            ->get();

        return view('productos.sin_publicar', compact('productos'));
    }

    public function publicar($slug)
    {
        $producto = Producto::where('slug', $slug)->firstOrFail();
        $producto->publicado = 1;
        $producto->save();
        return redirect('sin-publicar')->with('status', 'Producto publicado correctamente.');
    }

    public function invicta(Request $request)
    {
        $descuento = $request->descuento;
        $genero = $request->genero;
        $orden = $request->orden;

        //genero title
        $genero_name = match ($genero) {
            1 => 'para Mujer',
            2 => 'para Hombre', 
            3 => 'Unisex',
            default => ''
        };


        $productos = Producto::thumbnail(1)
            ->marca(67)
            ->genero($genero)
            ->oferta($descuento)
            ->ordenar($orden)
            ->get();

        foreach ($productos as $producto) {
            $producto->imagen = ($producto->imagenes->count() > 0) ? $producto->imagenes->first()->ruta : null;
        }


        $title = 'Relojes Invicta Costa Rica';

        return view('productos.invicta', compact('productos', 'genero', 'title'));
    }
}
