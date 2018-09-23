<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDetalheServicoSolicitacaosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('detalhe_servico_solicitacao', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('id_solicao');
            $table->unsignedInteger('id_servico');

            $table->foreign('id_solicao')
                  ->references('id')->on('solicitacao')
                  ->onDelete('cascade');

            $table->foreign('id_servico')
                  ->references('id')->on('servico')
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
        Schema::dropIfExists('detalhe_servico_solicitacaos');
        DB::statement('SET FOREIGN_KEY_CHECKS = 1');
    }
}
