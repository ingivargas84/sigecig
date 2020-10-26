<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSigecigVentaDeTimbresTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sigecig_venta_de_timbres', function (Blueprint $table) {
            $table->increments('id');
            $table->bigInteger('recibo_detalle_id');
            $table->bigInteger('numeracion_inicial');
            $table->bigInteger('numeracion_final');
            $table->integer('estado_id')->nullable();
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
        Schema::dropIfExists('sigecig_venta_de_timbres');
    }
}
