<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBitacoraBoletaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sigecig_bitacora_boleta', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('no_boleta');
            $table->string('accion',100);
            $table->unsignedinteger('user_id');
            $table->date('fecha');

            $table->foreign('user_id')->references('id')->on('users');
            
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
        Schema::dropIfExists('sigecig_bitacora_boleta');
    }
}
