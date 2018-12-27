<?php

namespace App\Http\Controllers\Painel;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Pedido;
use App\Http\Requests\PedidoRequest;
use Illuminate\Support\Facades\DB;

class PedidoController extends Controller
{
    private $pedido;

    public function __construct(Pedido $pedido){
        $this->pedido = $pedido;
    }

    public function getVendas(){
        $sql = "SELECT 
                    p.id,
                    DATE_FORMAT(p.venda_realizada_em, '%d/%m/%Y %H:%i:%s') data_venda,
                    c.nome nome_cliente,
                    c.cpf_cnpj cpf_cliente,
                    (SELECT SUM(ip.preco_unit*ip.quantidade) 
                            FROM items_pedidos ip 
                            WHERE ip.pedido_id = p.id) valor_total
    
                FROM pedidos p,
                    clientes c
                
                WHERE p.cliente_id = c.id";

        $results = DB::select(DB::raw($sql));  
        return $results;
    }

    public function index()
    {
        //
    }

    public function create()
    {
        //
    }

    public function store(PedidoRequest $request)
    {
        $dadosPedido = $request->all();
        
        $pedidoAux = array();
        $pedidoAux['data_pedido'] = $this->humanDTtoDataBaseDT($dadosPedido['data_pedido']);
        $pedidoAux['venda_realizada_em'] = $pedidoAux['data_pedido'];
        $pedidoAux['cliente_id']         = $dadosPedido['cliente_id'];
        
        $insertPedido = $this->pedido->create($pedidoAux);

        $returnMessage = "";

        if($insertPedido){
            $pedido_id = $insertPedido->id;
            $pedidoAux['items'] = $dadosPedido['items'];

            $itemPedidoAux = array();
            foreach($pedidoAux['items'] as $item){
                $itemPedidoAux[] = [
                    'preco_unit' => $item['preco_unit'],
                    'quantidade' => $item['quantidade'],
                    'produto_id' => $item['produto_id'],
                    'pedido_id' => $pedido_id
                ];
            }
            $insertItems = DB::table('items_pedidos')->insert($itemPedidoAux);
            if($insertItems){
                $returnMessage = "Venda realizada com sucesso.";
            }else{
                $returnMessage = "Ocorreu um erro ao tentar salvar os items. Tente mais tarde.";
            }
        }else{
            $returnMessage = "Ocorreu um erro ao realizar a venda, tente mais tarde.";
        }
        return response()->json([
            'message' => $returnMessage
        ]);
    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        //
    }

    public function update(PedidoRequest $request, $id)
    {
        //
    }

    public function destroy($id)
    {
        //
    }

    public function humanDTtoDataBaseDT($data_hora){
        $arr = explode(' ', $data_hora);
        $data = $arr[0];
        $hora = $arr[1];

        $data = implode('-', array_reverse(explode('/', $data)));
        return $data." ".$hora;
    }
}
