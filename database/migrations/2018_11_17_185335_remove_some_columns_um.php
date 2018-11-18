<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RemoveSomeColumnsUm extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('produto', function($table) {
            // $table->dropColumn('id_contrato');
            // $table->dropColumn('valor_imposto');
            // $table->dropColumn('link_oferta');
        });

        Schema::table('servico', function($table) {
            $table->dropColumn('id_contrato');
            $table->dropColumn('valor_imposto');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
