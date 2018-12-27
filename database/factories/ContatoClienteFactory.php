<?php

use App\Models\ContatoCliente;
use Faker\Generator as Faker;

$factory->define(ContatoCliente::class, function (Faker $faker) {
    return [
        'tipo' => 'telefone', 
        'contato' => $faker->phoneNumber, 
        'descricao' => 'Telefone para contato', 
        'cliente_id' => 1
    ];
});
