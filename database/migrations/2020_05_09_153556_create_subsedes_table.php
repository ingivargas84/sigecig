<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSubsedesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sigecig_subsedes', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nombre_sede');
            $table->string('direccion');
            $table->string('telefono');
            $table->string('telefono_2');
            $table->string('correo_electronico');
            $table->integer('estado');
            $table->softDeletes();
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
        Schema::dropIfExists('sigecig_subsedes');
    }
}
