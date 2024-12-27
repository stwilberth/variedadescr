<?php

namespace anuncielo\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class productoCreate extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'nombre' => 'required',
            'stock' => 'required|integer',
            'costo' => 'required|numeric',
            'marca' => 'required',
            'modelo' => 'required',
            'genero' => 'required',
            'precio_anterior' => 'nullable|numeric',
            'precio_sugerido' => 'nullable|numeric',
            'precio_venta' => 'required|numeric',
            'descripcion_social' => 'required|max:125',
            'url_tiktok' => 'nullable|url'
        ];
    }
    public function attributes()
    {
        return [
            'nombre' => 'Nombre',
            'stock' => 'Stock',
            'costo' => 'Costo',
            'catalogo' => 'Catálogo',
            'marca' => 'Marca',
            'modelo' => 'Modelo/Tipo',
            'genero' => 'Género',
            'moneda' => 'Moneda',
            'descuento' => 'Descuento',
            'precio_anterior' => 'Precio Anterior',
            'precio_sugerido' => 'Precio Sugerido',
            'precio_venta' => 'Precio Venta',
            'disponibilidad' => 'Disponibilidad',
            'descripcion' => 'Descripción',
            'descripcion_social' => 'Descripción Social'
        ];
    }
}
