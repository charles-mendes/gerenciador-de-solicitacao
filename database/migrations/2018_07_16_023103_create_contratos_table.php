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
        Schema::create('contrato', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('id_usuario');
            $table->unsignedInteger('id_fornecedor');
            $table->string('tipo');
            $table->date('data_vencimento');
            $table->enum('status', ['A', 'I']);
            $table->integer('id_modificador');
            $table->timestamp('data_criacao');
            $table->timestamp('data_modificacao')->nullable();

            $table->foreign('id_usuario')
                    ->references('id')->on('usuario')
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
        Schema::dropIfExists('contrato');
    }
}
