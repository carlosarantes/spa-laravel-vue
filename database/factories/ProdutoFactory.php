<?php

use App\Models\Produto;
use Faker\Generator as Faker;

$factory->define(Produto::class, function (Faker $faker) {
    return [
        'referencia' => $faker->numberBetween(10000, 100000),  
        'descricao' => $faker->sentence, 
        'marca' => $faker->word, 
        'preco_venda' => $faker->randomFloat(2, 10, 1000), 
        'estoque' => $faker->numberBetween(1, 100), 
        'unidade_venda' => 'unid.'
    ];
});
