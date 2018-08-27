<?php

use Faker\Generator as Faker;

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| This directory should contain each of the model factory definitions for
| your application. Factories provide a convenient way to generate new
| model instances for testing / seeding your application's database.
|
*/

$factory->define(App\Usuario::class, function (Faker $faker) {
    return [
        'nome' => $faker->firstName,
        'email' => $faker->unique()->safeEmail,
        'senha' => bcrypt('secret'),
        'situacao' => 'A',
        'id_criador' => 1,
        // 'data_criacao' => time(),
        'id_modificador' => 1,
        // 'data_modificacao' => time(),
        'tipo_conta' => 'A', 
    ];
});
