<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSigecigIngresoBodegaDetalleTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sigecig_ingreso_bodega_detalle', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamp('fecha_ingreso');
            $table->bigInteger('ingreso_maestro_id');
            $table->integer('tipo_de_pago_id');
            $table->integer('planchas');
            $table->integer('unidad_por_plancha');
            $table->bigInteger('numeracion_inicial');
            $table->bigInteger('numeracion_final');
            $table->bigInteger('cantidad');
            $table->double('total',10,2);
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
        Schema::dropIfExists('sigecig_ingreso_bodega_detalle');
    }
}
