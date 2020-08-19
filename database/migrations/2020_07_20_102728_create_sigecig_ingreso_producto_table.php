<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSigecigIngresoProductoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sigecig_ingreso_producto', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('timbre_id');
            $table->bigInteger('cantidad');
            $table->bigInteger('numeracion_inicial')->nullable();
            $table->bigInteger('numeracion_final')->nullable();
            $table->integer('bodega_id');
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
        Schema::dropIfExists('sigecig_ingreso_producto');
    }
}
