<?php

use App\Models\Pedido;
use Faker\Generator as Faker;

$factory->define(Pedido::class, function (Faker $faker) {
    return [
        'data_pedido' => $faker->dateTime, 
        'venda_realizada_em' => $faker->dateTime, 
        'cliente_id' => 1
    ];
});
