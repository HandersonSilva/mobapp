<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Aux_carrinho_promocao extends Model
{
    //
    protected $fillable = [
        'qtd_promocao',
        'valor_total_prod',
        'carrinho_id',
        'promocao_id',
        'promocao',
        'obs_pedido',
        'unique_cart_hash'
    ];

}
