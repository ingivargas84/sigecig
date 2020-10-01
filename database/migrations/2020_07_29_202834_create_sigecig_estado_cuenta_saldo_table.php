<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSigecigEstadoCuentaSaldoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sigecig_estado_cuenta_saldo', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('no_colegiado');
            $table->integer('mes_id');
            $table->integer('año');
            $table->double('saldo');
            $table->DateTime('fecha');
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
        Schema::dropIfExists('sigecig_estado_cuenta_saldo');
    }
}
