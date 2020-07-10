<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSigecigBodegaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sigecig_bodega', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nombre_bodega');
            $table->string('descripcion');
            $table->integer('estado'); //este estado es el que nos indica si se encuentra activado (1) o desaactivado (0).
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sigecig_bodega');
    }
}
