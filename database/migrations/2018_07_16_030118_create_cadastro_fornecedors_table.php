<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCadastroFornecedorsTable extends Migration
{
  const CREATED_AT = 'data_cadastro_fornecedor';
  const UPDATED_AT = 'data_modific_cadastro';
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cadastro_fornecedor', function (Blueprint $table) {
            $table->increments('id_cadastro_forn');
            $table->timestamps('data_cadastro_fornecedor');
            $table->timestamps('data_modific_cadastro');

            $table->foreign('id_fornecedor')
                  ->references('id_forn')->on('fornecedores')
                  ->onDelete('cascade')->after('id_cadastro_forn');

            $table->foreign('id_usuario_cadastro_forn')
                  ->references('id_usu')->on('usuarios')
                  ->onDelete('cascade')->after('id_fornecedor');



        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('cadastro_fornecedors');
    }
}
