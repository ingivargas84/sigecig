<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSigecigReciboTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sigecig_recibo', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('serie_recibo_id');
            $table->integer('numero_recibo');
            $table->integer('numero_de_identificacion');
            $table->integer('tipo_de_cliente_id');
            $table->string('complemento');
            $table->double('monto_efecectivo',10,2);
            $table->double('monto_tarjeta',10,2);
            $table->double('monto_cheque',10,2);
            $table->integer('usuario');
            $table->double('monto_total',10,2);
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
        Schema::dropIfExists('sigecig_recibo');
    }
}
