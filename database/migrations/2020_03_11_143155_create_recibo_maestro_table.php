<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateReciboMaestroTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('recibo_maestro', function (Blueprint $table) {
            $table->increments('id');
            $table->date('fecha_recibo');
            $table->string('serie');
            $table->string('num_recibo');
            $table->integer('no_colegiado');
            $table->string('nombre_colegiado');
            $table->string('anulado');
            $table->float('efectivo');
            $table->float('tarjeta');
            $table->float('cheque');
            $table->float('total_recibo');
            $table->timestamp('fecha_ingreso');
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
        Schema::dropIfExists('recibo_maestro');
    }
}
