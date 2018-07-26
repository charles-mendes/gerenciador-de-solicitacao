<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSolicitacaoTable extends Migration
{
  const CREATED_AT = 'data_criacao_solic';
  // const UPDATED_AT = 'data_modific_solic';


    public function up()
    {
        Schema::create('solicitacao', function (Blueprint $table) {
            $table->increments('id_solic');
            $table->char('status_atual_solic',1);
            $table->string('descricao_solic');
            $table->timestamps('data_criacao_solic');
            // $table->timestamps('data_modific_solic');

            $table->foreign('id_usuario_solic')
                  ->references('id_usu')->on('usuarios')
                  ->onDelete('cascade')->after('id_solic');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('solicitacao');
    }
}
