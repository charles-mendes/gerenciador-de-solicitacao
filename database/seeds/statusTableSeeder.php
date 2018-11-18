<?php

use Illuminate\Database\Seeder;

class statusTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('situacao')->insert(['tipo_status' => 'Pendente']);
        DB::table('situacao')->insert(['tipo_status' => 'Aprovado pelo Aprovador']);
        DB::table('situacao')->insert(['tipo_status' => 'Aprovado pelo Comprador']);
        DB::table('situacao')->insert(['tipo_status' => 'Aprovado pelo Administrador']);
        DB::table('situacao')->insert(['tipo_status' => 'Aprovado pela Diretoria']);
        DB::table('situacao')->insert(['tipo_status' => 'Reprovado pelo Aprovador']);
        DB::table('situacao')->insert(['tipo_status' => 'Reprovado pelo Comprador']);
        DB::table('situacao')->insert(['tipo_status' => 'Reprovado pela Diretoria']);
        DB::table('situacao')->insert(['tipo_status' => 'Reprovado pelo Administrador']);
        DB::table('situacao')->insert(['tipo_status' => 'Esperando Aprovação da diretoria']);
        DB::table('situacao')->insert(['tipo_status' => 'Iniciou Cotação']);
        DB::table('situacao')->insert(['tipo_status' => 'Finalizou Cotação']);
        DB::table('situacao')->insert(['tipo_status' => 'Processando solicitação']);
        DB::table('situacao')->insert(['tipo_status' => 'Finalizada']);
        DB::table('situacao')->insert(['tipo_status' => 'Inativada']);
        
    }
}
