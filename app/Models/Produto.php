<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Produto extends Model
{
    protected $table = 'produtos';
    protected $fillable = ['referencia', 'descricao', 'marca', 'preco_venda', 'estoque', 'unidade_venda'];

    public function itensPedido(){
        return $this->hasMany(ItemPedido::class);        
    }
}