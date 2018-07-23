<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSolicitacaoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('solicitacao', function (Blueprint $table) {
            $table->increments('id_solic');
            $table->foreign('id_usuario_solic')
                  ->references('id_usu')->on('usuario')
                  ->onDelete('cascade');
            $table->char('status_atual_solic',1);
            $table->string('descricao_solic');
            $table->date('data_criacao_solic');
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
        Schema::dropIfExists('solicitacao');
        Schema::dropForeign(['id_usuario_solic']);
    }
}
