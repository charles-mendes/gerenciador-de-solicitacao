<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableDiretoria extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('diretoria', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('id_usuario');
            $table->integer('id_solicitacao');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS = 0');
        Schema::dropIfExists('diretoria');
        DB::statement('SET FOREIGN_KEY_CHECKS = 1');
    }
}
