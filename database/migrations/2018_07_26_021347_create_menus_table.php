<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMenusTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('menu', function (Blueprint $table) {
          $table->increments('id');
           $table->string('nome');
           $table->string('link');
           $table->string('icone');
           $table->enum('situacao', ['A', 'I']);
           $table->integer('ordem');
           $table->integer('id_menu_pai')->nullable();
           $table->integer('id_criador');
           $table->timestamp('data_criacao');
           $table->integer('id_modificador');
           $table->timestamp('data_modificacao')->nullable();

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('menu');
    }
}
