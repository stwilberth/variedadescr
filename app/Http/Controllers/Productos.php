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
use anuncielo\Services\EmailService;
use anuncielo\Models\Subscriber;
use Illuminate\Support\Facades\Cache;
use anuncielo\Services\CacheKeys;

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

        $marca_nombre = '';
        if ($marca_id) {
            $marca = Marca::find($marca_id);
            $marca_nombre = $marca ? ' ' . $marca->nombre : '';
        }

        //genero title
        $genero_name = match ($genero) {
            '1' => ' para Mujer',
            '2' => ' para Hombre', 
            '3' => ' Unisex',
            default => ''
        };

        $descuento_name = match ($descuento) {
            '1' => ' con descuento',
            '2' => ' en oferta',
            default => ''
        };

        $productos = Producto::select('id', 'slug', 'nombre', 'precio_venta', 'oferta', 'catalogo')
            ->with('catalogoM', 'imagenes')
            ->where('stock', '>', 0)
            ->where('disponibilidad', '!=', 3)
            ->where('catalogo', $catalogo_id)
            ->marca($marca_id)
            ->genero($genero)
            ->oferta($descuento)
            ->ordenar($orden)
            ->get();

        $title = ucfirst($catalogo_slug) . $marca_nombre . $genero_name . $descuento_name;

        return view('productos.index', compact('productos', 'marca_id', 'genero', 'marcas', 'catalogo_slug', 'title'));
    }

    public function create(Request $request)
    {
        $marcas = Marca::orderBy('catalogo', 'asc')->orderBy('nombre', 'asc')->get();
        return view('productos.create', compact('marcas'));
    }

    public function store(Request $request)
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

        return redirect('image-edit/'.$producto->slug)->with('status', 'Producto guardado correctamente.');
    }

    public function show(Request $request, $categoria, $slug)
    {
        $catalogo = Cache::remember(CacheKeys::catalogo($categoria), 60 * 24, function () use ($categoria) {
            return Catalogo::where('slug', $categoria)->firstOrFail();
        });

        $admin = false;
        if (Auth::user() && Auth::user()->AutorizaRoles('admin')) {
            $producto = Cache::remember(CacheKeys::producto($slug, true), 60 * 24, function () use ($slug, $catalogo) {
                return Producto::with(['imagenes', 'marca', 'catalogoM'])
                ->where('slug', $slug)
                ->catalogo($catalogo->id)
                ->withoutGlobalScopes()
                ->firstOrFail();
            });
            $admin = true;
        } else {
            $producto = Cache::remember(CacheKeys::producto($slug), 60 * 24, function () use ($slug, $catalogo) {
                return Producto::with(['imagenes', 'marca', 'catalogoM'])
                ->where('slug', $slug)
                ->catalogo($catalogo->id)
                ->first();
            });

            if (!$producto) {
                return redirect()->route('catalogoIndex', ['categoria' => $categoria]);
            }
        }

        if ($catalogo->id != $producto->catalogoM->id) {
            return redirect()->route('catalogoIndex', ['categoria' => 'relojes']);
        }

        // Cachear productos relacionados por 30 minutos
        $more_products = Cache::remember(CacheKeys::productosRelacionados($producto->id), 60 * 24, function () use ($producto) {
            return Producto::with('imagenes')
            ->select('id', 'slug', 'nombre', 'precio_venta', 'oferta', 'catalogo')
            ->orderBy('created_at', 'desc')
            ->where('id', '!=', $producto->id)
            ->marca($producto->marca_id)
            ->catalogo($producto->catalogo)
            ->where('stock', '>', 0)
            ->where('disponibilidad', '!=', 3)
            ->limit(12)
            ->get();
        });

        // Cachear productos nuevos por 6 horas
        $new_products = Cache::remember(CacheKeys::productosNuevos(), 60 * 24, function () use ($producto) {
            return Producto::with('imagenes')
            ->select('id', 'slug', 'nombre', 'precio_venta', 'oferta', 'catalogo')
            ->orderBy('created_at', 'desc')
            ->where('id', '!=', $producto->id)
            ->where('created_at', '>=', date('Y-m-d', strtotime('-30 days')))
            ->where('stock', '>', 0)
            ->where('disponibilidad', '!=', 3)
            ->limit(12)
            ->get();
        });

        $title = $producto->nombre;
    
        return view('productos.show', compact('producto', 'admin', 'more_products', 'new_products', 'title')); 
    }

    public function edit(Request $request, $slug)
    {
        $producto = Producto::where('slug', $slug)
            ->withoutGlobalScopes()
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
            ->withoutGlobalScopes()
            ->firstOrFail();

        $old_slug = $producto->slug;
        $old_marca_id = $producto->marca_id;
        $old_catalogo = $producto->catalogo;

            $producto->nombre = $request->nombre;
            $producto->descripcion = $request->descripcion;
            $producto->descripcion_social = $request->descripcion_social;
            $producto->genero = $request->genero;
            $producto->marca_id = $request->marca;
            $producto->modelo = $request->modelo;
            $producto->catalogo = $marca->catalogo;
            $producto->publicado = (int)$request->publicado;
            $producto->oferta = $request->oferta;
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

        // Limpiar caché del producto anterior y nuevo
        Cache::forget(CacheKeys::producto($old_slug));
        Cache::forget(CacheKeys::producto($old_slug, true));
        Cache::forget(CacheKeys::producto($producto->slug));
        Cache::forget(CacheKeys::producto($producto->slug, true));
        
        // Limpiar caché de productos relacionados
        Cache::forget(CacheKeys::productosRelacionados($producto->id));
        Cache::forget(CacheKeys::productosNuevos());
        
        // Limpiar caché de marcas si cambió de marca o catálogo
        if ($old_marca_id != $producto->marca_id || $old_catalogo != $producto->catalogo) {
            Cache::forget(CacheKeys::marcasCatalogo($old_catalogo));
            Cache::forget(CacheKeys::marcasCatalogo($producto->catalogo));
            Cache::forget(CacheKeys::marca($old_marca_id));
            Cache::forget(CacheKeys::marca($producto->marca_id));
        }

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

    public function agotados(Request $request)
    {
        $productos = Producto::withoutGlobalScopes()
            ->with(['marca', 'catalogoM'])
            ->where('disponibilidad', 3)
            ->orderBy('catalogo', 'asc')
            ->orderBy('stock', 'desc')
            ->orderBy('costo', 'asc')
            ->get();

        return view('productos.agotados', compact('productos'));
    }

    public function publicar($slug)
    {
        $producto = Producto::where('slug', $slug)->withoutGlobalScopes()->firstOrFail();
        $producto->publicado = 1;
        $producto->save();
        return redirect('sin-publicar')->with('status', 'Producto publicado correctamente.');
    }

    //notificar
    public function notificar(Request $request, $slug){
        $producto = Producto::where('slug', $slug)->withoutGlobalScopes()->firstOrFail();
 
        $emailService = new EmailService();
        // Only get confirmed subscribers
        $subscribers = Subscriber::where('is_confirmed', true)->get();
        
        foreach($subscribers as $subscriber) {
            $emailService->sendNewProductNotification($subscriber, $producto);
        }

        return redirect()->back()->with('status', 'Email enviado correctamente a los suscriptores verificados.');
    }

    /**
     * API methods for external access
     */
    
    // Get all products (relojes)
    public function apiGetProducts(Request $request)
    {
        $descuento = $request->descuento;
        $marca_id = $request->marca;
        $genero = $request->genero;
        $catalogo_slug = 'relojes';
        $catalogo_id = ($catalogo_slug == 'relojes') ? 1 : 2;
        $orden = $request->orden ?? 'fecha';

        $productos = Producto::select('productos.id', 'productos.slug', 'productos.nombre', 'productos.precio_venta', 'productos.oferta', 'productos.genero', 'productos.descripcion')
            ->with(['imagenes' => function($query) {
                $query->select('ruta', 'producto_id');
            }])
            ->where('stock', '>', 0)
            ->where('disponibilidad', 0)
            ->where('catalogo', $catalogo_id)
            ->marca($marca_id)
            ->genero($genero)
            ->oferta($descuento);

        // Si el orden es desc o asc, ordenamos por precio, sino por fecha
        if ($orden === 'desc' || $orden === 'asc') {
            $productos->orderBy('precio_venta', $orden);
        } else {
            $productos->orderBy('created_at', 'desc');
        }
            
        $productos = $productos->get();
            
        return response()->json([
            'success' => true,
            'data' => $productos,
            'message' => 'Productos obtenidos correctamente'
        ]);
    }
    
    // Get a single product by slug
    public function apiGetProduct($slug)
    {
        try {
            $producto = Producto::with(['imagenes', 'marca', 'catalogoM'])
            ->where('slug', $slug)
            ->where('publicado', 1)
            ->firstOrFail();
                
            return response()->json([
                'success' => true,
                'data' => $producto,
                'message' => 'Producto obtenido correctamente'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Producto no encontrado',
                'error' => $e->getMessage()
            ], 404);
        }
    }
    
    // Get featured or new products
    public function apiGetFeaturedProducts(Request $request)
    {
        $limit = $request->input('limit', 8);
        $type = $request->input('type', 'new'); // 'new' or 'featured'
        
        $query = Producto::select('id', 'slug', 'nombre', 'precio_venta', 'oferta', 'catalogo', 'genero', 'created_at')
            ->with(['imagenes' => function($query) {
                $query->select('id', 'producto_id','ruta', 'orden')->orderBy('orden', 'asc')->limit(1);
            }])
            ->where('stock', '>', 0)
            ->where('disponibilidad', '!=', 3)
            ->where('publicado', 1);
            
        if ($type === 'new') {
            $query->where('created_at', '>=', date('Y-m-d', strtotime('-30 days')))
                  ->orderBy('created_at', 'desc');
        } else {
            // Featured products (with discount)
            $query->where('oferta', '>', 0)
                  ->orderBy('oferta', 'desc');
        }
        
        $productos = $query->limit($limit)->get();
        
        return response()->json([
            'success' => true,
            'data' => $productos,
            'message' => 'Productos destacados obtenidos correctamente'
        ]);
    }
    
    // Get available brands
    public function apiGetBrands(Request $request)
    {
        $catalogo_id = $request->input('catalogo', 1); // Default to relojes (1)
        
        $marcas = Marca::where('catalogo', $catalogo_id)
            ->whereHas('productos', function ($query) {
                $query->where('stock', '>', 0)
                    ->where('disponibilidad', '!=', 3)
                    ->where('publicado', 1);
            })
            ->orderBy('nombre', 'asc')
            ->get(['id', 'nombre']);
            
        return response()->json([
            'success' => true,
            'data' => $marcas,
            'message' => 'Marcas obtenidas correctamente'
        ]);
    }
}
