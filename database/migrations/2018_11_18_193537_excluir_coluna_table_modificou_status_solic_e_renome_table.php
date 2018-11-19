<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ExcluirColunaTableModificouStatusSolicERenomeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('modificou_status_solicitacao', function($table) {
            $table->dropColumn('id_modificador');
        });
        Schema::rename('modificou_status_solicitacao', 'historico_solicitacao');
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
