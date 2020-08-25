<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSigecigReciboDepositoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sigecig_recibo_deposito', function (Blueprint $table) {
            $table->increments('id');
            $table->increments('numero_recibo');
            $table->double('monto',10,2);
            $table->integer('numero_boleta');
            $table->timestamp('fecha');
            $table->integer('banco_id');
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
        Schema::dropIfExists('sigecig_recibo_deposito');
    }
}
