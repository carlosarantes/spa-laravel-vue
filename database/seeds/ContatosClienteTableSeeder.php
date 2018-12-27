<?php

use App\Models\ContatoCliente;
use Illuminate\Database\Seeder;

class ContatosClienteTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(ContatoCliente::class, 2)->create();
    }
}
