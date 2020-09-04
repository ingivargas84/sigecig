<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateReciboDetalleTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sigecig_recibo_detalle', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('numero_recibo');
            $table->string('codigo_compra');
            $table->integer('cantidad');
            $table->double('precio_unitario',10,2);
            $table->double('total',10,2);
            $table->integer('id_mes');
            $table->string('año');
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
        Schema::dropIfExists('sigecig_recibo_detalle');
    }
}
