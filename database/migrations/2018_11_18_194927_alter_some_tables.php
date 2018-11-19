<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterSomeTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
     
        Schema::table('solicitacao', function(Blueprint $table) {
            $table->dropColumn('status');
            $table->integer('id_status')->default('1')->after('id');
        });
        
        // trocando nome da tebela 
        Schema::rename('situacao', 'status');
       
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
