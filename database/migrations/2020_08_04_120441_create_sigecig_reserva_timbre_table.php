<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSigecigReservaTimbreTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sigecig_reserva_timbre', function (Blueprint $table) {
                $table->increments('id');
                $table->integer('id_ingreso_producto');
                $table->integer('id_tipo_pago')->nullable();
                $table->integer('id_categoria_pago')->nullable();
                $table->integer('no_colegiado');
                $table->integer('cantidad');
                $table->integer('estado');
                $table->DateTime('fecha_hora');
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
        Schema::dropIfExists('sigecig_reserva_timbre');
    }
}
