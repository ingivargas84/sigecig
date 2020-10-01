<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterConstraintKrnEstadocuentaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
    $query = "SELECT * FROM information_schema.TABLE_CONSTRAINTS 
    WHERE information_schema.TABLE_CONSTRAINTS.CONSTRAINT_TYPE = 'FOREIGN KEY' 
    AND information_schema.TABLE_CONSTRAINTS.TABLE_SCHEMA = 'cig_db1' 
    AND information_schema.TABLE_CONSTRAINTS.TABLE_NAME = 'krn_estadocuenta' 
    AND CONSTRAINT_NAME = 'FK_krn_estadocuenta_servicio'";

    $resp = DB::connection('mysql')->select($query);
    if(!empty($resp)){
        Schema::table('krn_estadocuenta', function (Blueprint $table) {
            $table->dropForeign('FK_krn_estadocuenta_servicio');
         });
    }

    
    }


    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
