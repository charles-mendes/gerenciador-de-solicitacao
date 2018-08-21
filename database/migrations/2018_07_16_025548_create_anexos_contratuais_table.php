<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAnexosContratuaisTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('anexo_contratual', function (Blueprint $table) {
            $table->increments('id');
            $table->string('caminho_path');
            $table->unsignedInteger('id_tipo');
            $table->unsignedInteger('id_contrato');
            $table->integer('id_criador');
            $table->timestamp('data_criacao');
            $table->integer('id_modificador');
            $table->timestamp('data_modificacao')->nullable();

            $table->foreign('id_tipo')
                  ->references('id')->on('tipo_anexo_contratual')
                  ->onDelete('cascade');
            $table->foreign('id_contrato')
                  ->references('id')->on('contrato')
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
        Schema::dropIfExists('anexo_contratual');
    }
}
