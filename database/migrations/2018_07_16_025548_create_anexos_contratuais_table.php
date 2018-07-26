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
        Schema::create('anexos_contratuais', function (Blueprint $table) {
            $table->increments('id_ac');
            $table->string('caminho_path_ac');
            $table->timestamps();
            $table->foreign('id_tipo')
                  ->references('id_tipo_ac')->on('tipo_anexo_contratuais')
                  ->onDelete('cascade');
            $table->foreign('id_contrato_AC')
                  ->references('id_contrato')->on('contratos')
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
        Schema::dropIfExists('anexos_contratuais');
    }
}
