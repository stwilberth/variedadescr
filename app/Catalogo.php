<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Catalogo extends Model
{
    protected $table = 'catalogo';
    public function productos()
    {
        return $this->hasMany('App\Producto');
    }
}
