<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDetalheServicoFornecedorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('detalhe_servico_fornecedor', function (Blueprint $table) {
            $table->increments('id_detServForn');

            $table->foreign('id_serv_detServForn')
                  ->references('id_serv')->on('servicos')
                  ->onDelete('cascade');

            $table->foreign('id_forn_detServForn')
                  ->references('id_forn')->on('fornecedores')
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
        Schema::dropIfExists('detalhe_servico_fornecedors');
    }
}
