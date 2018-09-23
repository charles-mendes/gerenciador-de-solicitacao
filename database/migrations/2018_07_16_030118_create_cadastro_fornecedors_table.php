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
            $table->increments('id');
            $table->unsignedInteger('id_fornecedor');
            $table->unsignedInteger('id_usuario');
            $table->integer('id_criador');
            $table->timestamp('data_criacao');
            $table->integer('id_modificador');
            $table->timestamp('data_modificacao')->nullable();


            $table->foreign('id_fornecedor')
                  ->references('id')->on('fornecedor')
                  ->onDelete('cascade');

            $table->foreign('id_usuario')
                  ->references('id')->on('usuario')
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
        Schema::dropIfExists('cadastro_fornecedor');
        DB::statement('SET FOREIGN_KEY_CHECKS = 1');
    }
}
