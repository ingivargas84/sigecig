<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSigecigReciboTarjetaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sigecig_recibo_tarjeta', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('numero_recibo');
            $table->integer('numero_voucher');
            $table->double('monto',10,2);
            $table->integer('pos_cobro_id');
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
        Schema::dropIfExists('sigecig_recibo_tarjeta');
    }
}
