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
            $table->integer('estado_cuenta_maestro_id');
            $table->integer('cantidad');
            $table->integer('tipo_pago_id');
            $table->bigInteger('recibo_id');
            $table->double('abono',10,2);
            $table->double('cargo',10,2);
            $table->integer('usuario_id');
            $table->integer('id_mes')->nullable();
            $table->string('año',10)->nullable();
            $table->integer('estado_id');
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
