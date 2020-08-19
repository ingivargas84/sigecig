<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSigecigCajasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sigecig_cajas', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nombre_caja');
            $table->string('cajero');
            $table->string('subsede');
            $table->string('bodega');
            $table->integer('estado'); //este estado es el que nos indica si se encuentra activado (0) o desaactivado (1).
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
        Schema::dropIfExists('sigecig_cajas');
    }
}
