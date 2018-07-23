<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateContratosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('contratos', function (Blueprint $table) {
          $table->increments('id_contrato');
          $table->string('tipo_contrato');
          $table->date('data_criacao_contrato');
          $table->date('data_vencimento_contrato');
          $table->string('status_documento_anexos_contrato');
          $table->foreign('id_usuario')
                ->references('id_usu')->on('usuario')
                ->onDelete('cascade');
          $table->foreign('id_forn')
                ->references('id_forn')->on('fornecedor')
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
        Schema::dropIfExists('contratos');
    }
}
