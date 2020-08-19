<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class SigecigSolicitudesBitacoraAp extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sigecig_solicitudes_bitacora_ap', function (Blueprint $table) {
            $table->increments('id');
            $table->Integer('no_solicitud');
            $table->DateTime('fecha');
            $table->Integer('estado_solicitud');
            $table->Integer('usuario');
            $table->Integer('id_creacion')->nullable();
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
        Schema::dropIfExists('sigecig_solicitudes_bitacora_ap');
    }
}
