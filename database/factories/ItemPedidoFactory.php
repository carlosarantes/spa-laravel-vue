<?php

use App\Models\ItemPedido;
use Faker\Generator as Faker;

$factory->define(ItemPedido::class, function (Faker $faker) {
    return [
     'preco_unit' => $faker->randomFloat(2, 10, 1000), 
     'quantidade' => $faker->numberBetween(1, 100), 
     'produto_id' => 1, 
     'pedido_id' => 1
    ];
});
