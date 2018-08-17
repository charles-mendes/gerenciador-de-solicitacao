<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDetalheProdutoFornecedorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('detalhe_produto_fornecedor', function (Blueprint $table) {
            $table->increments('id');

            $table->foreign('id_produto')
                  ->references('id')->on('produto')
                  ->onDelete('cascade');

            $table->foreign('id_fornecedor')
                ->references('id')->on('fornecedor')
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
        Schema::dropIfExists('detalhe_produto_fornecedor');
    }
}
