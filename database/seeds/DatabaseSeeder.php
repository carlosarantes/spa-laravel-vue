<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
			UsersTableSeeder::class,
			ClientesTableSeeder::class,
			ContatosClienteTableSeeder::class,
			ProdutosTableSeeder::class,
			PedidosTableSeeder::class,
			ItemsPedidoTableSeeder::class
        ]);
    }
}
