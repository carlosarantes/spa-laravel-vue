<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cliente extends Model
{
    protected $table = 'clientes';
    protected $fillable = ['nome', 'cpf_cnpj', 'endereco', 'num', 'bairro', 'cep', 'cidade', 'estado'];


    /*
    public $rules = [
		'nome' => 'required|min:3|max:100', 
		'cpf_cnpj' => 'required|min:11|max:18', 
		'endereco' => 'max:50', 
		'num' => 'max:8', 
		'bairro' => 'max:50', 
		'cep' => 'max:10', 
		'cidade' => 'max:80', 
		'estado' => 'max:20'
    ];
    */

    public function contatos(){
        return $this->hasMany(ContatoCliente::class);
    }

    public function pedidos(){
        return $this->hasMany(Pedido::class);
    }
}
