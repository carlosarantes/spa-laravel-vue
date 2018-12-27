<?php

namespace App\Http\Controllers\Painel;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Cliente;
use App\Http\Requests\ClienteRequest;

class ClienteController extends Controller
{   
    private $cliente;

    public function __construct(Cliente $cliente){
        $this->cliente = $cliente;
    }

    public function index()
    {
        $clientes = $this->cliente->all();
        return $clientes;
    }

    public function create()
    {
        //
    }
        // auth()->user();
        // $request->user();
         // $request->user()->comentarios()->get(); // EXEMPLO RELACIONAMENTO
        // $request->user()->comentarios()->criar([]); // EXEMPLO RELACIONAMENTO
        // $this->cliente->contatos();

        //

        /*
            $this->validate($request, $this->cliente->rules);
            $validate = Validator::make($request->all(), $this->cliente->rules);
            $messages = [
                'nome.required' => 'O nome é obrigatorio.';
            ];
            $validate = validator($request->all(), $this->cliente->rules, $messages);
            if( $validate->fails() ){
                return redirect()
                        ->route('clientes.create')
                        ->withErrors($validate)
                        ->withInput();
            }
        */


    public function store(ClienteRequest $request){
        $insert = $this->cliente->create($request->all());
        if($insert){
            return response()->json([
                'message' => "Cliente cadastrado com sucesso.",
                'id' => $insert->id
            ]);
        }
    }

    public function show($id)
    {
        /*
            $cliente = $this->cliente->find($id);  
            $cliente->contatos();

            $cliente = $this->cliente->with('contatos')->find($id);  
             
            $contatos = $cliente->contatos;    
            
            $cliente = $this->cliente->with('contatos.outroRelacionamento')->find($id);  
            $cliente = $this->cliente->with(['contatos.outroRelacionamento', 'relacionamentoEntity'])->find($id);
        */  
    }

    public function edit($id)
    {
        //
    }

    public function update(ClienteRequest $request, $id)
    {
        $cliente = $this->cliente->find($id);

        $update = $cliente->update($request->all());
        if($update){
            return response()->json([
                'message' => "Cliente alterado com sucesso."
            ]);
        }
    }

    public function destroy($id)
    {
        $cliente = $this->cliente->find($id);

        $delete = $cliente->delete();
        if($delete){
            return response()->json([
                'message' => "Cliente removido com sucesso."
            ]);
        }
    }
}