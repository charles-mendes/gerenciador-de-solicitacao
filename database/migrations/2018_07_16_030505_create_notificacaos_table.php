<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateNotificacaosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('notificacao', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('id_solicitacao');
            $table->unsignedInteger('id_modificou_status_solicitacao');
            $table->string('mensagem');

            $table->foreign('id_solicitacao')
                  ->references('id')->on('solicitacao')
                  ->onDelete('cascade');

            $table->foreign('id_modificou_status_solicitacao')
                  ->references('id')->on('modificou_status_solicitacaos')
                  ->onDelete('cascade');

            $table->char('finalizou_visualizacao');//


        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('notificacao');

    }
}
