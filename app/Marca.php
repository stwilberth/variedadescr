<?php

namespace anuncielo;

use Illuminate\Database\Eloquent\Model;

class Marca extends Model
{
    public function productos()
    {
        return $this->hasMany('anuncielo\Producto');
    }

    //catalogoM
    public function catalogoM()
    {
        return $this->belongsTo('anuncielo\Catalogo', 'catalogo');
    }
}
