<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSigecigCorteDeCajaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sigecig_corte_de_caja', function (Blueprint $table) {
            $table->increments('id');
            $table->double('monto_total',10,2);
            $table->double('total_efectivo',10,2);
            $table->double('total_cheque',10,2);
            $table->double('total_tarjeta',10,2);
            $table->double('total_deposito',10,2);
            $table->integer('id_caja');
            $table->integer('id_usuario');
            $table->DateTime('fecha_corte');
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
        Schema::dropIfExists('sigecig_corte_de_caja');
    }
}
