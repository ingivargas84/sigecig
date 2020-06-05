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
            $table->string('no_cuenta', 20);
            $table->integer('no_solicitud');
            $table->integer('no_acta')->nullable();
            $table->string('no_punto_acta', 10)->nullable();
            $table->DateTime('fecha_pago_ap')->nullable();
            $table->string('pdf_dpi_ap', 255)->nullable();
            $table->string('pdf_solicitud_ap', 100)->nullable();
            $table->string('solicitud_rechazo_ap', 500)->nullable();
            $table->string('solicitud_rechazo_junta', 500)->nullable();
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
