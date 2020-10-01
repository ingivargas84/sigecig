<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSigecigEstadoDeCuentaMaestroTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sigecig_estado_de_cuenta_maestro', function (Blueprint $table) {
            $table->increments('id');
            $table->bigInteger('colegiado_id');
            $table->integer('estado_id');
            $table->timestamp('fecha_creacion');
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
        Schema::dropIfExists('sigecig_estado_de_cuenta_maestro');
    }
}
