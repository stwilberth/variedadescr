<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('productos', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->timestamps();
            //datos
            $table->string('nombre');
            $table->string('descripcion');
            $table->integer('genero');
            $table->string('marca');
            $table->string('modelo');
            $table->boolean('nuevo')->nullable();
            //publicacion
            $table->string('catalogo')->nullable();
            $table->boolean('destacado')->nullable();
            $table->boolean('slider')->nullable();
            $table->boolean('publicado')->nullable();
            //precio
            $table->boolean('oferta')->nullable();
            $table->date('fecha_inicio')->nullable();
            $table->date('fecha_fin')->nullable();
            $table->integer('moneda');
            $table->float('costo');
            $table->float('precio_anterior')->nullable();
            $table->float('precio_venta');
            $table->integer('descuento')->nullable();
            $table->float('precio_sugerido')->nullable();
            //inventario
            $table->string('codigo')->nullable();
            $table->integer('stock');
            $table->integer('disponibilidad');
            //multimedia
            $table->string('img')->nullable();
            $table->string('video')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('productos');
    }
}
