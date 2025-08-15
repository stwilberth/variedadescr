<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Imagen extends Model
{
    protected $table = 'producto_imagenes';
    protected $fillable = [
        'producto_id',
        'ruta',
        'nombre'
    ];
    public function producto()
    {
        return $this->belongsTo(Producto::class);
    }
}
