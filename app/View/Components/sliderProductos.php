<?php

namespace App\View\Components;

use Illuminate\View\Component;
use App\Producto;

class sliderProductos extends Component
{
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public $products;
    public $titulo;

    public function __construct($products, $titulo)
    {
        $this->titulo = $titulo;
        $this->products = $products;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render()
    {
        return view('components.slider-productos');
    }
}
