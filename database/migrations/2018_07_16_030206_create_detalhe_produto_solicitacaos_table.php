<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDetalheProdutoSolicitacaosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('detalhe_produto_solicitacaos', function (Blueprint $table) {
            $table->increments('id');

            $table->foreign('id_solic_detProdSolic')
                  ->references('id_solic')->on('solicitacao')
                  ->onDelete('cascade')->after('id');

            $table->foreign('id_produto_detProdSolic')
                  ->references('id_produto')->on('produtos')
                  ->onDelete('cascade')->after('id_solic_detProdSolic');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('detalhe_produto_solicitacaos');
    }
}
