<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProdutosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('produtos', function (Blueprint $table) {
            $table->increments('id_produto');
            $table->string('nome_prod');
            $table->int('quantidade_prod');
            $table->float('valor_prod');
            $table->float('valor_imposto_prod');
            $table->string('descricao_prod');
            $table->string('link_oferta_prod');
            $table->foreign('id_contrato_prod')
                  ->references('id_contrato')->on('contratos')
                  ->onDelete('cascade');
            // $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('produtos');
    }
}
