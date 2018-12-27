<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ContatoClienteRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return  [
            'tipo' => 'required', 
            'contato' => 'required|min:8', 
            'cliente_id' => 'required'
        ];
    }

    public function messages(){
        return [
            'tipo.required' => 'Tipo é obrigatorio.',
            'contato.required' => 'O contato é obrigatório.',
            'contato.min' => 'O contato deve ter pelo menos 8 caracteres.',
            'cliente_id.required' => 'É necessario informar a qual cliente este contato pertence.'
        ];        
    }
}
