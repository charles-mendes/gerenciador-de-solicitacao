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
            $table->char('finalizou_visualizacao');

            $table->foreign('id_solicitacao')
                  ->references('id')->on('solicitacao')
                  ->onDelete('cascade');

            $table->foreign('id_modificou_status_solicitacao')
                  ->references('id')->on('modificou_status_solicitacao')
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
        Schema::dropIfExists('notificacao');
        DB::statement('SET FOREIGN_KEY_CHECKS = 1');

    }
}
