<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateServicosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('servico', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nome');
            $table->float('valor');
            $table->string('descricao');

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
        Schema::dropIfExists('servico');
        DB::statement('SET FOREIGN_KEY_CHECKS = 1');
    }
}
