<?php

namespace anuncielo;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Producto extends Model
{
    protected $fillable = [
    'nombre',
    'descripcion',
    'descripcion_social',
    'genero',
    'marca_id',
    'modelo',
    'nuevo',
    'catalogo',
    'destacado',
    'slider',
    'publicado',
    'oferta',
    'fecha_inicio',
    'fecha_fin',
    'moneda',
    'costo',
    'precio_anterior',
    'precio_venta',
    'descuento',
    'precio_sugerido',
    'codigo',
    'stock',
    'disponibilidad'
    ];

    protected $appends = ['currency_symbol'];

    public function getRouteKeyName()
    {
        return 'slug';
    }
    public function scopeMarca($query, $marca)
    {
        if ($marca) {
            return $query->where('marca_id', $marca);
        }
    }
    public function scopeGenero($query, $genero)
    {
        if ($genero) {
            return $query->where('genero', $genero);
        }
    }
    public function scopeCatalogo($query, $catalogo)
    {
        if ($catalogo) {
            return $query->where('catalogo', $catalogo);
        }
    }
    public function scopePublicado($query, $publicado = null)
    {
        if (Auth::check() && Auth::user()->AutorizaRoles('admin')) {
            if($publicado){
                return $query->where('publicado', 1);
            } else {
                return $query;
            }
        } else {
            return $query->where('publicado', 1);
        }
    }

    public function catalogoM()
    {
        return $this->belongsTo(Catalogo::class, 'catalogo');
    }

    public function marca()
    {
        return $this->belongsTo('anuncielo\Marca');
    }

    public function imagenes()
    {
        return $this->hasMany('anuncielo\Imagen');
    }

    public function addImagen($ruta, $nombre)
    {
        $imagen = $this->imagenes()->create([
            'ruta' => $ruta,
            'nombre' => $nombre
        ]);

        return $imagen;
    }


    public function getCurrencySymbolAttribute()
    {
        return $this->attributes['moneda'] === 1 ? '¢' : '$';
    }

    public function getGeneroTextoAttribute()
    {
        switch ($this->attributes['genero']) {
            case 1:
                return "Mujer";
            case 2:
                return "Hombre";
            case 3:
                return "Unisex";
            default:
                return "Desconocido";
        }
    }

    public function getMonedaSimboloAttribute()
    {
        return $this->attributes['moneda'] === 1 ? '¢' : '$';
    }

    // Disponibilidad
    public function getDisponibilidadTextoAttribute()
    {
        switch ($this->attributes['disponibilidad']) {
            case 0:
                return 'Inmediata';
            case 1:
                return 'Una semana';
            case 2:
                return 'Dos semanas';
            case 3:
                return 'Agotado';
            default:
                return '';
        }
    }
}
