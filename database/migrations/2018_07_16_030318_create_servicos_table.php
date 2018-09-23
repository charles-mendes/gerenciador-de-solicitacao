<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateServicosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('servico', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('id_contrato');
            $table->string('nome');
            $table->float('valor');
            $table->float('valor_imposto');
            $table->string('descricao');

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
        Schema::dropIfExists('servico');
        DB::statement('SET FOREIGN_KEY_CHECKS = 1');
    }
}
