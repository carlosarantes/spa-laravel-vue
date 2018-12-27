<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ContatoCliente extends Model
{
    protected $table = 'contatos_clientes';
    protected $fillable = ['tipo', 'contato', 'descricao', 'cliente_id'];

    public function cliente(){
        return $this->belongsTo(Cliente::class);        
    }
}