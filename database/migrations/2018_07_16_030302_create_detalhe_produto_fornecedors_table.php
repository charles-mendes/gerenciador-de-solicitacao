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
        Schema::create('detalhe_produto_fornecedors', function (Blueprint $table) {
            $table->increments('id_detProdForn');

            $table->foreign('id_produto_detProdForn')
                  ->references('id_produto')->on('produtos')
                  ->onDelete('cascade')->after('id_detProdForn');

                  $table->foreign('id_forn_detProdForn')
                        ->references('id_forn')->on('fornecedores')
                        ->onDelete('cascade')->after('id_produto_detProdForn');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('detalhe_produto_fornecedors');
    }
}
