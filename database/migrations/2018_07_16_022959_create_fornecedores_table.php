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
        Schema::create('fornecedores', function (Blueprint $table) {
            $table->increments('id_forn');
            $table->string('nome_forn');
            $table->string('cpnj_forn');
            $table->char('status_contato_forn',1);
            $table->string('telefone_forn');
            $table->string('email_forn');
            $table->string('categoria_forn');
            $table->date('data_forn');
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
        Schema::dropIfExists('fornecedors');
    }
}
