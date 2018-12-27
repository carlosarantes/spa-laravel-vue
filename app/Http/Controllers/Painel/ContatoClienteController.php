<?php

namespace App\Http\Controllers\Painel;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\ContatoCliente;
use App\Http\Requests\ContatoClienteRequest;

class ContatoClienteController extends Controller
{
    private $contato_cliente;

    public function __construct(ContatoCliente $contato_cliente){
        $this->contato_cliente = $contato_cliente;
    }

    public function index()
    {
        
    }
    
    public function contatosPorCliente($cliente_id)
    {
        $contatos = $this->contato_cliente->where('cliente_id', $cliente_id)->get();
        return $contatos;
    }

    public function create()
    {
        //
    }

    public function store(ContatoClienteRequest $request)
    {
        $insert = $this->contato_cliente->create($request->all());
        if($insert){
            return response()->json([
                'message' => "Contato do cliente cadastrado com sucesso.",
                'id' => $insert->id
            ]);
        }
    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        //
    }

    public function update(ContatoClienteRequest $request, $id)
    {
        //
    }

    public function destroy($id)
    {
        $contato_cliente = $this->contato_cliente->find($id);

        $delete = $contato_cliente->delete();
        if($delete){
            return response()->json([
                'message' => "Contato removido com sucesso."
            ]);
        }
    }
}
