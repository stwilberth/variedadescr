<?php

namespace anuncielo;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    public function users()
    {
        return $this->belongsToMany('anuncielo\User');
    }
}
