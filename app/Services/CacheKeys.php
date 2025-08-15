<?php

namespace App\Services;

class CacheKeys
{
    public static function productos($catalogo_slug, $marca_id = null, $genero = null, $descuento = null, $orden = null)
    {
        return "productos.{$catalogo_slug}.{$marca_id}.{$genero}.{$descuento}.{$orden}";
    }

    public static function producto($slug, $isAdmin = false)
    {
        return "producto." . ($isAdmin ? 'admin.' : '') . $slug;
    }

    public static function catalogo($slug)
    {
        return "catalogo.{$slug}";
    }

    public static function productosRelacionados($productoId)
    {
        return "more_products.{$productoId}";
    }

    public static function productosNuevos()
    {
        return "new_products";
    }

    public static function marca($marcaId)
    {
        return "marca.{$marcaId}";
    }

    public static function marcasCatalogo($catalogoId)
    {
        return "marcas.{$catalogoId}";
    }

    /**
     * Genera una clave de caché para la página de bienvenida
     */
    public static function welcomeKey($marca = null)
    {
        return $marca ? "welcome.marca.{$marca}" : "welcome.ofertas";
    }
}
