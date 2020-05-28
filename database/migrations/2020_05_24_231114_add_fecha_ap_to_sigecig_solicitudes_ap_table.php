<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddFechaApToSigecigSolicitudesApTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('sigecig_solicitudes_ap', function (Blueprint $table) {
            $table->DateTime('fecha_pago_ap')->after('pdf_solicitud_ap');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('sigecig_solicitudes_ap', function (Blueprint $table) {
        });
    }
}
