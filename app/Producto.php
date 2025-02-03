<?php

namespace anuncielo;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Builder;

class Producto extends Model
{
    protected $fillable = [
    'nombre',
    'descripcion',
    'descripcion_social',
    'genero',
    'marca_id',
    'modelo',
    'catalogo',
    'publicado',
    'oferta',
    'moneda',
    'costo',
    'precio_anterior',
    'precio_venta',
    'descuento',
    'precio_sugerido',
    'stock',
    'disponibilidad'
    ];

    protected static function boot()
    {
        parent::boot();
        
        static::addGlobalScope('publicado', function (Builder $builder) {
            $builder->where('publicado', 1);
        });
    }


    // metodo helper para cuando quieras ver solo sin publicar
    public function scopeSinPublicar($query) {
        return $query->withoutGlobalScope('publicado')->where('publicado', 0);
    }

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

    //scope oferta
    function scopeOferta($query, $valor) {
        if($valor) {
            return $query
            ->where('oferta', $valor);
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

    public function getImagenAttribute()
    {
        return $this->imagenes->count() > 0 ? $this->imagenes->first()->ruta : null;
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


    public function scopeOrdenar($query, $orden)
    {
        return match ($orden) {
            'asc' => $query->orderBy('precio_venta', 'asc'),
            'desc' => $query->orderBy('precio_venta', 'desc'),
            default => $query->orderBy('created_at', 'desc'),
        };
    }

    public function scopeThumbnail($query, $catalogo)
    {
        return $query->select('id', 'slug', 'nombre', 'precio_venta', 'oferta', 'catalogo')
            ->with('catalogoM')
            ->where('stock', '>', 0)
            ->where('disponibilidad', '!=', 3)
            ->where('catalogo', $catalogo);
    }
}
