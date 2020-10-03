<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSigecigAnulacionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sigecig_anulacion', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamp('fecha_solicitud');
            $table->string('razon_solicitud',220)->nullable();
            $table->integer('usuario_cajero_id');
            $table->bigInteger('recibo_id');
            $table->integer('estado_recibo_id');
            $table->timestamp('fecha_aprueba_rechazo')->nullable();
            $table->integer('usuario_aprueba_rechaza')->nullable();
            $table->string('razon_rechazo',220)->nullable();
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
        Schema::dropIfExists('sigecig_anulacion');
    }
}
