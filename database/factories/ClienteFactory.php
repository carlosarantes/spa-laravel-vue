<?php

use App\Models\Cliente;
use Faker\Generator as Faker;

$factory->define(Cliente::class, function (Faker $faker) {
    return [
        'nome' => $faker->name, 
        'cpf_cnpj' => '111.111.111-00', 
        'endereco' => $faker->streetName, 
        'num' => $faker->buildingNumber, 
        'bairro' => '.', 
        'cep' => $faker->postcode, 
        'cidade' => $faker->city, 
        'estado' => '.'
    ];
});
