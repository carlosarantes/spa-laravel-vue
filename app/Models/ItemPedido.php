<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ItemPedido extends Model
{
    protected $table    = 'items_pedidos';
    protected $fillable = ['preco_unit', 'quantidade', 'produto_id', 'pedido_id'];

    public function produto(){
        return $this->belongsTo(Produto::class);        
    }

    public function pedido(){
        return $this->belongsTo(Pedido::class);        
    }
}
