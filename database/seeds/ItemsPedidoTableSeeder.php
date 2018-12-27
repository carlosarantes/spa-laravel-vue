<?php

use App\Models\ItemPedido;
use Illuminate\Database\Seeder;

class ItemsPedidoTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(ItemPedido::class, 4)->create();
    }
}
