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
        Schema::create('detalhe_servico_solicitacaos', function (Blueprint $table) {
            $table->increments('id_detServSolic');

            $table->foreign('id_solic_detServSolic')
                  ->references('id_solic')->on('solicitacao')
                  ->onDelete('cascade');

            $table->foreign('id_serv_detServSolic')
                  ->references('id_serv')->on('servicos')
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
        Schema::dropIfExists('detalhe_servico_solicitacaos');
    }
}
