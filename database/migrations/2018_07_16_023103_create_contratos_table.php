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
            $table->unsignedInteger('id_fornecedor');
            $table->string('numero_contrato');
            $table->enum('status', ['A', 'I']);
            $table->string('descricao');
            $table->integer('id_criador');
            $table->timestamp('data_criacao');
            $table->integer('id_modificador');
            $table->integer('data_modificacao');
            $table->date('data_vencimento');
            $table->enum('status_anexo', ['0', '1']);
        
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
        DB::statement('SET FOREIGN_KEY_CHECKS = 0');
        Schema::dropIfExists('contrato');
        DB::statement('SET FOREIGN_KEY_CHECKS = 1');
    }
}
