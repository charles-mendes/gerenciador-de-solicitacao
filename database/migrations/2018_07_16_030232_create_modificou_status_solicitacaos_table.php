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

     // const CREATED_AT = 'data_criacao_solic';
     const UPDATED_AT = 'data_modific_solic';


    public function up()
    {
        Schema::create('modificou_status_solicitacao', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('id_solicitacao');
            $table->unsignedInteger('id_status');
            $table->unsignedInteger('id_usuario');

            
            $table->foreign('id_solicitacao')
                  ->references('id')->on('solicitacao')
                  ->onDelete('cascade');

            $table->foreign('id_status')
                  ->references('id')->on('status')
                  ->onDelete('cascade');

            $table->foreign('id_usuario')
                  ->references('id')->on('usuario')
                  ->onDelete('cascade');

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
        Schema::dropIfExists('modificou_status_solicitacao');
    }
}
