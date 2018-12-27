<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProdutoRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'referencia' => 'required|min:3', 
            'descricao' => 'required|min:5|max:100', 
            'marca' => 'required|min:3', 
            'preco_venda' => 'required|numeric', 
            'estoque' => 'required|numeric', 
            'unidade_venda' => 'required|max:20'
        ];
    }

    public function messages(){
        return [
            'referencia.required' => 'O campo referencia é obrigatório.',
            'referencia.min' => 'O campo referencia deve ter no minimo 3 caracteres.',
            'descricao.required' => 'O campo descrição é obrigatório.',
            'descricao.min' => 'O campo descrição deve ter entre 5 e 100 caracteres.',
            'descricao.max' => 'O campo descrição deve ter entre 5 e 100 caracteres.',
            'marca.required' => 'O campo marca é obrigatório.',
            'marca.min' => 'O campo marca deve ter no mínimo 3 caracteres.',
            'preco_venda.required' => 'O campo preço de venda é obrigatório.',
            'preco_venda.numeric' => 'O campo preço de venda aceita somente numeros.',
            'estoque.required' => 'O campo estoque é obrigatório.',
            'estoque.numeric' => 'O campo estoque deve ser numerico.',
            'unidade_venda.required' => 'O campo unidade de venda é obrigatório.',
            'unidade_venda.max' => 'O campo unidade de venda deve ter no máximo 20 caracteres.'           
        ];        
    }
}
