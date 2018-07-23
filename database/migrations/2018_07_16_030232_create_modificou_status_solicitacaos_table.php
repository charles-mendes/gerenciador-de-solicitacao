<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateModificouStatusSolicitacaosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('modificou_status_solicitacaos', function (Blueprint $table) {
            $table->increments('id_modStatusSolic');
            $table->foreign('id_solic_modStatusSolic')
                  ->references('id_solic')->on('solicitacao')
                  ->onDelete('cascade');
            $table->foreign('id_status_modStatusSolic')
                  ->references('id_status')->on('status')
                  ->onDelete('cascade');
            $table->foreign('id_usuario_modStatusSolic')
                  ->references('id_usu')->on('usuarios')
                  ->onDelete('cascade');
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
        Schema::dropIfExists('modificou_status_solicitacaos');
    }
}
