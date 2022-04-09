<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Aux_pedido_carrinho extends Model
{
    //
    protected $fillable = [
        'carrinho_id',
        'pedidos_id',
    ];
}
