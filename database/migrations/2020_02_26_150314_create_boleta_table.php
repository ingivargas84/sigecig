<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBoletaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('boleta', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('no_boleta')->nullable()->unique();
            $table->string('nombre_usuario',80)->nullable();
            $table->integer('estado_boleta');
            $table->integer('estado_proceso');
            $table->integer('solicitud_boleta_id');
            
            //$table->foreign('solicitud_boleta_id')->references('id')->on('solicitud_boleta');
            //$table->foreign('estado_boleta')->references('id')->on('estado_boleta');
            //$table->foreign('estado_proceso')->references('id')->on('estado_proceso');
            
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
        Schema::dropIfExists('boleta');
    }
}
