<?php

namespace App\Http\Controllers\Painel;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\ItemPedido;
use App\Http\Requests\ItemPedidoRequest;
use Illuminate\Support\Facades\DB;

class ItemPedidoController extends Controller
{

    private $item_pedido;

    public function __construct(ItemPedido $item_pedido){
        $this->item_pedido = $item_pedido;
    }

    public function index()
    {
        //
    }

    public function getItemsPorVenda($pedido_id){

        $sql = "SELECT ip.id,
                        p.descricao produto,
                        ip.preco_unit,
                        ip.quantidade,
                        ip.pedido_id
                    
                    FROM items_pedidos ip, 
                        produtos p
                        
                    WHERE ip.produto_id = p.id AND
                        ip.pedido_id  = '".$pedido_id."'";

        $results = DB::select(DB::raw($sql));  
        return $results;
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        //
    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        //
    }

    public function update(Request $request, $id)
    {
        //
    }

    public function destroy($id)
    {
        //
    }
}
