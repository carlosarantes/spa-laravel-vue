<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ClienteRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return  [
            'nome' => 'required|min:3|max:100', 
            'cpf_cnpj' => 'required|min:11|max:18', 
            'endereco' => 'max:50', 
            'num' => 'max:8', 
            'bairro' => 'max:50', 
            'cep' => 'max:10', 
            'cidade' => 'max:80', 
            'estado' => 'required'
        ];
    }

    public function messages(){
        return [
            'nome.required' => 'Nome é obrigatorio.',
            'nome.min' => 'O nome deve ter entre 3 e 100 caracteres.',
            'nome.max' => 'O nome deve ter entre 3 e 100 caracteres.',
            'cpf_cnpj.required' => 'CPF/CNPJ é obrigatório.',
            'cpf_cnpj.min' => 'CPF/CNPJ deve ter entre 11 e 18 caracteres.',
            'cpf_cnpj.max' => 'CPF/CNPJ deve ter entre 11 e 18 caracteres.',
            'endereco.max' => 'Endereço deve ter no máximo 50 caracteres.',
            'num.max' => 'Numero deve ter no máximo 8 caracteres.',
            'bairro.max' => 'Bairro deve ter no maximo 50 caracteres.',
            'cep.max' => 'CEP deve ter no máximo 10 caracteres.',
            'cidade.max' => 'Cidade deve ter no maximo 80 caracteres.',
            'estado.required' => 'Estado é obrigatório.'
        ];        
    }
}
