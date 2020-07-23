<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSigecigTraspasoMaestroTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sigecig_traspaso_maestro', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('bodega_origen_id');
            $table->integer('bodega_destino_id');
            $table->bigInteger('cantidad_de_timbres');
            $table->timestamp('fecha_ingreso');
            $table->integer('usuario_id');
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
        Schema::dropIfExists('sigecig_traspaso_maestro');
    }
}
