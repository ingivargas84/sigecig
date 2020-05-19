<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateColaboradorTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sigecig_colaborador', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nombre');
            $table->string('dpi');
            $table->integer('puesto');
            $table->integer('departamento');
            $table->string('telefono');
            $table->integer('estado');
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
        Schema::dropIfExists('sigecig_colaborador');
    }
}
