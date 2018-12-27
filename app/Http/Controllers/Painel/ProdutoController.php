<?php

namespace App\Http\Controllers\Painel;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Produto;
use App\Http\Requests\ProdutoRequest;

class ProdutoController extends Controller
{
    private $produto;

    public function __construct(Produto $produto){
        $this->produto = $produto;
    }

    public function index()
    {
        $produtos = $this->produto->all();
        return $produtos;
    }

    public function create()
    {
        //
    }

    public function store(ProdutoRequest $request)
    {
        $insert = $this->produto->create($request->all());
        if($insert){
            return response()->json([
                'message' => "Produto cadastrado com sucesso.",
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

    public function update(ProdutoRequest $request, $id)
    {
        $produto = $this->produto->find($id);
        $update = $produto->update($request->all());
        if($update){
            return response()->json([
                'message' => "Produto alterado com sucesso."
            ]);
        }
    }

    public function destroy($id)
    {
        $produto = $this->produto->find($id);

        $delete = $produto->delete();
        if($delete){
            return response()->json([
                'message' => "Produto removido com sucesso."
            ]);
        }
    }
}
