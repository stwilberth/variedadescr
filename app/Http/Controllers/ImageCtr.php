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
                function numberToLetters($number) {
                    $cadena1 = strval($number);
                    $letters = 'abcdefghijklmnopqrstuvwxyz';  
                    $cadena2 = '';
                    foreach (str_split($cadena1) as $numero) {
                        foreach (str_split($letters) as $i => $letter) {
                            if($numero == $i) {
                                $cadena2 .= $letter;
                            }
                        }
                    }
                
                    return $cadena2;
                }
                
                $uniqueName = numberToLetters(time()).uniqid();
                $crop = json_decode($request->medidas_crop);
                $img = $request->file('img');
    
                $w = (int)$crop->w; 
                $h = (int)$crop->h; 
                $x = (int)$crop->x; 
                $y = (int)$crop->y;
    
                $ruta = $Producto->id.'_'.$uniqueName.'.'.$img->getClientOriginalExtension();
    
                $img_crop = Image::make($img->getRealPath())->crop($w, $h, $x, $y)->resize(720, 720);
                $img_thumb = Image::make($img->getRealPath())->crop($w, $h, $x, $y)->resize(255, 255);
    
                $Producto->addImagen($ruta, $img->getClientOriginalName());
    
                $img_thumb->save(public_path('/storage/productos/thumb_' . $ruta));
                $img_crop->save(public_path('/storage/productos/' . $ruta));
    
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