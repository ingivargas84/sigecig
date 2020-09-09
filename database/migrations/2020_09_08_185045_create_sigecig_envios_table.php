<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSigecigEnviosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sigecig_envios', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('id_recibo_maestro');
            $table->integer('id_forma_entrega');
            $table->integer('id_municipio')->nullable();
            $table->integer('id_departamento')->nullable();
            $table->string('detalle_direccion', 100)->nullable();
            $table->integer('telefono');
            $table->string('encargado', 100);
            $table->string('dpi_encargado', 100)->nullable();
            $table->integer('id_sede')->nullable();
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
        Schema::dropIfExists('sigecig_envios');
    }
}
