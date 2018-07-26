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
        Schema::create('notificacaos', function (Blueprint $table) {
            $table->increments('id_notific');

            $table->string('mensagem_notific');

            $table->foreign('id_detSolicHistorico')
                  ->references('id_solic')->on('solicitacao')
                  ->onDelete('cascade');

            $table->foreign('id_modifStatusSolic_notific')
                  ->references('id_modStatusSolic')->on('modificou_status_solicitacaos')
                  ->onDelete('cascade');

            $table->char('finalizou_visualizacao');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('notificacaos');

    }
}
