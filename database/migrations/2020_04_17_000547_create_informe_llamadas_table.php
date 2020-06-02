<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInformeLlamadasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sigecig_informe_llamadas', function (Blueprint $table) {
            $table->increments('id');
            $table->datetime('fecha_hora');
            $table->integer('colegiado');
            $table->integer('telefono');
            $table->string('observaciones',3000);
            $table->integer('userid');
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
        Schema::dropIfExists('sigecig_informe_llamadas');
    }
}
