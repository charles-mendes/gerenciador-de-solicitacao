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
            $table->unsignedInteger('id_contrato');
            $table->string('descricao');
            $table->string('caminho_path');
            $table->integer('id_criador');
            $table->timestamp('data_criacao');
            $table->integer('id_modificador');
            $table->timestamp('data_modificacao')->nullable();

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
        DB::statement('SET FOREIGN_KEY_CHECKS = 0');
        Schema::dropIfExists('anexo_contratual');
        DB::statement('SET FOREIGN_KEY_CHECKS = 1');
    }
}
