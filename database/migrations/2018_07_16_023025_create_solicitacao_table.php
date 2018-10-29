<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSolicitacaoTable extends Migration
{
    //   const CREATED_AT = 'data_criacao_solic';
    // const UPDATED_AT = 'data_modific_solic';


    public function up()
    {
        Schema::create('solicitacao', function (Blueprint $table) {
            $table->increments('id');
            $table->enum('status', ['P','A','R','E'])->default('P')
            ->comment('P = Pendente A = Aprovado R = reprovado E = excluiu solicitação');
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
        Schema::dropIfExists('solicitacao');
        DB::statement('SET FOREIGN_KEY_CHECKS = 1');
    }
}
