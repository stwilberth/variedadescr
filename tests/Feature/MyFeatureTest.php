<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use anuncielo\Producto;
use anuncielo\Imagen;

class MyFeatureTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function test_example()
    {
        $productos = Producto::all();

        foreach($productos as $producto) {
            $imgsDB = $producto->img;
            $arrayImgs = array();
    
            if ($producto->img) {
                if ($imgsDB[0] == '[') {
                    $arrayImgs = json_decode($imgsDB, true);
                } else {
                    $imgsComas = explode(",", $imgsDB);
                    for ($i=0; $i < count($imgsComas); $i++) { 
                        $imagen = array('name' => $imgsComas[$i], 'peso' => $i);
                        array_push($arrayImgs, $imagen);
                    }
                }
                //dd($arrayImgs);

                foreach ($arrayImgs as $imagenData) {
                    $imagen = new Imagen([
                        'ruta' => $imagenData['name'],
                        'nombre' => '',
                    ]);
                    
                    $producto->imagenes()->save($imagen);
                }
            }
        }
        
        
        
    }
}
