<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableDetalheProduto extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('detalhe_produto', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('id_produto');
            $table->string('chave');
            $table->string('valor');
            // $table->unsignedInteger('id_fornecedor');

            $table->foreign('id_produto')
                  ->references('id')->on('produto')
                  ->onDelete('cascade');

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
        Schema::dropIfExists('detalhe_produto');
        DB::statement('SET FOREIGN_KEY_CHECKS = 1');
    }
}
