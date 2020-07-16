<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSigecigEstadoDeCuentaDetalleTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sigecig_estado_de_cuenta_detalle', function (Blueprint $table) {
            $table->increments('id');
            $table->bigInteger('id_maestro');
            $table->DateTime('fecha_pago');
            $table->string('estado_actual');
            $table->double('saldo_total',10,2);
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
        Schema::dropIfExists('sigecig_estado_de_cuenta_detalle');
    }
}
