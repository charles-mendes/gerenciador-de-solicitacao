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
        DB::table('status')->insert(['tipo_status' => 'Pendente']);
        DB::table('status')->insert(['tipo_status' => 'Aprovado pelo Aprovador']);
        DB::table('status')->insert(['tipo_status' => 'Aprovado pelo Comprador']);
        DB::table('status')->insert(['tipo_status' => 'Aprovado pelo Administrador']);
        DB::table('status')->insert(['tipo_status' => 'Aprovado pela Diretoria']);
        DB::table('status')->insert(['tipo_status' => 'Reprovado pelo Aprovador']);
        DB::table('status')->insert(['tipo_status' => 'Reprovado pelo Comprador']);
        DB::table('status')->insert(['tipo_status' => 'Reprovado pela Diretoria']);
        DB::table('status')->insert(['tipo_status' => 'Reprovado pelo Administrador']);
        DB::table('status')->insert(['tipo_status' => 'Esperando Aprovação da diretoria']);
        DB::table('status')->insert(['tipo_status' => 'Iniciou Cotação']);
        DB::table('status')->insert(['tipo_status' => 'Finalizou Cotação']);
        DB::table('status')->insert(['tipo_status' => 'Em processo de execução']);
        DB::table('status')->insert(['tipo_status' => 'Finalizada']);
        DB::table('status')->insert(['tipo_status' => 'Inativada']);
        
    }
}
