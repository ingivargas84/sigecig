<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSigecigIngresoBodegaMaestroTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sigecig_ingreso_bodega_maestro', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('usuario_id');
            $table->bigInteger('cantidad_de_timbres');
            $table->double('total',10,2);
            $table->integer('codigo_bodega_id');
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
        Schema::dropIfExists('sigecig_ingreso_bodega_maestro');
    }
}
