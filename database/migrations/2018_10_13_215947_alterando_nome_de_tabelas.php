<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterandoNomeDeTabelas extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::rename('detalhe_produto_fornecedor', 'detalhe_fornecedor_produto');
        Schema::rename('detalhe_produto_solicitacao', 'detalhe_solicitacao_produto');
        Schema::rename('detalhe_servico_fornecedor', 'detalhe_forncedor_servico');
        Schema::rename('detalhe_servico_solicitacao', 'detalhe_solicitacao_servico');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
