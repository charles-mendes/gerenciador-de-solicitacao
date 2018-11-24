<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Generator as Faker;

class UsuarioSeeder extends Seeder
{

    public function run()
    {
        DB::table('usuario')->insert([
            'nome' => 'admin',
            'email' => 'admin@admin.com',
            'senha' => '$2y$10$fa1hm9LRbNG2DURIIuHzHO.0.5Nh.CzrqaOzu.rtMdYWlnY5QsupO',
            'situacao' => 'A',
            'tipo_conta' => 'AD'
        ]);

        DB::table('usuario')->insert([
            'nome' => 'professor',
            'email' => 'professor@testa.com',
            'senha' => '$2y$10$mg/bmBbHrkfmCPNgvgyQsunY/lrzYUsFEYuebtPrCO/YLdZHY5oQS',
            'situacao' => 'A',
            'tipo_conta' => 'AD'
        ]);

        DB::table('usuario')->insert([
            'nome' => 'aluno',
            'email' => 'aluno@testa.com',
            'senha' => '$2y$10$mg/bmBbHrkfmCPNgvgyQsunY/lrzYUsFEYuebtPrCO/YLdZHY5oQS',
            'situacao' => 'A',
            'tipo_conta' => 'AD'
        ]);

        DB::table('usuario')->insert([
            'nome' => 'estudante',
            'email' => 'estudante@testa.com',
            'senha' => '$2y$10$mg/bmBbHrkfmCPNgvgyQsunY/lrzYUsFEYuebtPrCO/YLdZHY5oQS',
            'situacao' => 'A',
            'tipo_conta' => 'AD'
        ]);
    }
}
