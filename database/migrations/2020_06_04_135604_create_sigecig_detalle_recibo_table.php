<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSigecigDetalleReciboTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sigecig_detalle_recibo', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('numero_recibo');
            $table->integer('codigo_compra');
            $table->integer('cantidad');
            $table->double('precio_unitario',10,2);
            $table->double('total',10,2);
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
        Schema::dropIfExists('sigecig_detalle_recibo');
    }
}
