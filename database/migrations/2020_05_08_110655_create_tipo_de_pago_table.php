<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTipoDePagoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sigecig_tipo_de_pago', function (Blueprint $table) {
            $table->increments('id');
            $table->string('codigo');
            $table->string('tipo_de_pago');
            $table->double('precio_colegiado',10,2)->nullable()->default(null);
            $table->double('precio_particular',10,2)->nullable()->default(null);
            $table->string('categoria_id');
            $table->integer('estado'); //este estado es el que nos indica si se encuentra activado (0) o desaactivado (1).
            $table->boolean('display_plataforma')->nullable()->default(null);
            $table->integer('tipo')->nullable()->default(null); 
            $table->integer('tipo_colegiatura')->nullable()->default(null); 
            $table->DateTime('fecha_desde')->nullable()->default(null);
            $table->DateTime('fecha_hasta')->nullable()->default(null);
            $table->double('monto_auxilio',10,2)->nullable()->default(null);
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
        Schema::dropIfExists('sigecig_tipo_de_pago');
    }
}
