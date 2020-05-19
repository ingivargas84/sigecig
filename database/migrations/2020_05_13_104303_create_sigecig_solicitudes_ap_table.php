<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSigecigSolicitudesApTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sigecig_solicitudes_ap', function (Blueprint $table) {
            $table->Increments('id');
            $table->DateTime('fecha_solicitud');
            $table->Integer('n_colegiado');
            $table->Integer('id_estado_solicitud');
            $table->integer('id_banco');
            $table->Integer('id_tipo_cuenta');
            $table->Integer('no_cuenta');
            $table->integer('no_solicitud');
            $table->integer('no_acta')->nullable();
            $table->string('no_punto_acta', 10)->nullable();
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
        Schema::dropIfExists('sigecig_solicitudes_ap');
    }
}
