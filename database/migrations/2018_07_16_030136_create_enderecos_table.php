<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEnderecosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('enderecos', function (Blueprint $table) {
            $table->increments('id_endereco');
              $table->string('endereco_end');
              $table->string('bairro_end');
              $table->string('cidade_end');
              $table->string('estado_end');
              $table->integer('numero_end');
              $table->string('cep_end');
              $table->string('pais_end');

              $table->foreign('id_fornecedor_end')
                    ->references('id_forn')->on('fornecedores')
                    ->onDelete('cascade')->after('id_endereco');

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
        Schema::dropIfExists('enderecos');
    }
}
