<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

//Model fornecedor


class CreateFornecedoresTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('fornecedor', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nome');
            $table->string('cnpj')->nullable();
            $table->enum('status', ['A','I'])->default('A');
            $table->string('telefone');
            $table->string('email');
            $table->string('descricao');
            $table->integer('id_criador');
            $table->timestamp('data_criacao');
            $table->integer('id_modificador');
            $table->timestamp('data_modificacao')->nullable();
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
        Schema::dropIfExists('fornecedor');
        DB::statement('SET FOREIGN_KEY_CHECKS = 1');
    }
}
