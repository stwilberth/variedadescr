<?php

namespace anuncielo\Http\Controllers;

use anuncielo\Imagen;
use anuncielo\Producto;
use DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Str;
use Image;

class ImageCtr extends Controller
{

    public function edit($slug)
    {
        $producto = Producto::where('slug', $slug)->firstOrFail();
        $title = $producto->nombre;

        return view('image.edit', compact('producto', 'title'));
    }

    public function save(Request $request)
    {
        $Producto = Producto::where('id', $request->id)->firstOrFail();

        if ($request->hasFile('img')) {
            try {
                $uniqueName = Str::random(10);
                $crop = json_decode($request->medidas_crop);
                $img = $request->file('img');
    
                $w = (int)$crop->w; 
                $h = (int)$crop->h; 
                $x = (int)$crop->x; 
                $y = (int)$crop->y;
    
                $ruta = $Producto->id.'_'.$uniqueName.'.'.$img->getClientOriginalExtension();
    
                // Crear imagen principal optimizada
                $img_crop = Image::make($img->getRealPath())
                    ->crop($w, $h, $x, $y)
                    ->resize(720, 720, function ($constraint) {
                        $constraint->aspectRatio();
                        $constraint->upsize();
                    })
                    ->encode('jpg', 80); // Comprimir con calidad 80%

                // Crear thumbnail optimizado
                $img_thumb = Image::make($img->getRealPath())
                    ->crop($w, $h, $x, $y)
                    ->resize(255, 255, function ($constraint) {
                        $constraint->aspectRatio();
                        $constraint->upsize();
                    })
                    ->encode('jpg', 75); // Comprimir con calidad 75% para thumbnails
    
                $Producto->addImagen($ruta, $img->getClientOriginalName());
    
                // Guardar las imágenes optimizadas
                $img_thumb->save(public_path('/storage/productos/thumb_' . $ruta), 75);
                $img_crop->save(public_path('/storage/productos/' . $ruta), 80);

                // Generar versiones WebP si el formato es soportado
                /*                 
                if (function_exists('imagewebp')) {
                    $webp_path = public_path('/storage/productos/' . pathinfo($ruta, PATHINFO_FILENAME) . '.webp');
                    $webp_thumb_path = public_path('/storage/productos/thumb_' . pathinfo($ruta, PATHINFO_FILENAME) . '.webp');
                    
                    $img_crop->encode('webp', 80)->save($webp_path);
                    $img_thumb->encode('webp', 75)->save($webp_thumb_path);
                } 
                */
    
                $Producto->save();
    
                return redirect('/image-edit/'.$Producto->slug)->with('status', 'OK');
                
            } catch (\Throwable $th) {
                return redirect('/image-edit/'.$Producto->slug)->with('status', 'Error al guardar la imagen');
            }
        } else {
            return redirect('/image-edit/'.$Producto->slug)->with('status', 'Tienes que seleccionar una imagen');
        }
    }
    public function update(Request $request)
    {
        $tour = Producto::where('id', $request->id)->firstOrFail();
        if (false) {
            return redirect('/image-edit/'.$tour->slug)->with('status', 'OK');
        } else {
            return redirect('/image-edit/'.$tour->slug)->with('status', 'Aun no disponible');
        }
    }

    public function delete(Request $req)
    {
        if (true) {
            $imagen = Imagen::findOrFail($req->id);
            //$producto = $imagen->producto;
            $producto = Producto::findOrFail($req->producto_id);
   
            try {
                $img_host = public_path('/storage/productos/' . $imagen->ruta);
                $img_host_thumb = public_path('/storage/productos/thumb_' . $imagen->ruta);
                unlink($img_host);
                unlink($img_host_thumb);
                $imagen->delete();
            } catch (\Throwable $th) {
                return redirect('/image-edit/'.$producto->slug)->with('status', 'Error al eliminar la imagen');
            }

            return redirect('/image-edit/'.$producto->slug)->with('status', 'OK');
        }
    }

}