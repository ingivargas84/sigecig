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

            $table->unsignedInteger('puesto')->nullable();
            $table->foreign('puesto')->references('id')->on('sigecig_puesto')->onDelete('cascade');

            $table->unsignedInteger('departamento')->nullable();
            $table->foreign('departamento')->references('id')->on('sigecig_departamento')->onDelete('cascade');

            $table->unsignedInteger('subsede')->nullable();
            $table->foreign('subsede')->references('id')->on('sigecig_subsedes')->onDelete('cascade');

            $table->string('telefono');

            $table->unsignedInteger('usuario')->nullable();
            $table->foreign('usuario')->references('id')->on('sigecig_users')->onDelete('cascade');

            $table->integer('estado')->default(1);
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
