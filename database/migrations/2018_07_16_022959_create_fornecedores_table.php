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
            $table->string('cpnj');
            //TODO :: nao entendi esse
            $table->char('status_contato_forn',1);
            $table->string('telefone');
            $table->string('email');
            $table->string('categoria');
            $table->integer('id_criador');
            $table->timestamp('data_criacao');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('fornecedor');
    }
}
