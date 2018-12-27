<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pedido extends Model
{
    protected $table    = 'pedidos';
    protected $fillable = ['data_pedido', 'venda_realizada_em', 'cliente_id'];

    public function cliente(){
        return $this->belongsTo(Cliente::class);        
    }

    public function itensPedido(){
        return $this->hasMany(ItemPedido::class);        
    }
}