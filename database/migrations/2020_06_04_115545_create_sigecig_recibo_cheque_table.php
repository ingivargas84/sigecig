<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSigecigReciboChequeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sigecig_recibo_cheque', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('numero_recibo');
            $table->integer('numero_cheque');
            $table->double('monto',10,2);
            $table->string('nombre_banco')->nullable();
            $table->integer('usuario_id');
            $table->timestamp('fecha_de_cheque');
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
        Schema::dropIfExists('sigecig_recibo_cheque');
    }
}
