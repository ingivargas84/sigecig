<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSolicitudBoletaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sigecig_solicitud_boleta', function (Blueprint $table) {
            $table->increments('id');
            $table->date('fecha');
            $table->integer('departamento_id');
            $table->string('descripcion_boleta',1000)->nullable();
            $table->string('responsable',100);
            $table->unsignedinteger('user_id');
            $table->integer('estado_solicitud');
            $table->string('quien_la_usara',100);

            $table->foreign('user_id')->references('id')->on('users');
            //$table->foreign('estado_solicitud')->references('id')->on('estado_solicitud');

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
        Schema::dropIfExists('sigecig_solicitud_boleta');
    }
}
