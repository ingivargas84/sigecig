<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSigecigTraspasoDetalleTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sigecig_traspaso_detalle', function (Blueprint $table) {
            $table->increments('id');
            $table->bigInteger('traspaso_maestro_id');
            $table->integer('tipo_pago_timbre_id');
            $table->bigInteger('cantidad_a_traspasar');
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
        Schema::dropIfExists('sigecig_traspaso_detalle');
    }
}
