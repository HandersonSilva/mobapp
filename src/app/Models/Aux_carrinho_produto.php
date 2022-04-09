<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Aux_carrinho_produto extends Model
{
    //
    protected $fillable = [
        'qtd_produto',
        'valor_total_prod',
        'carrinho_id',
        'produto_id',
        'promocao',
        'obs_pedido',
        'unique_cart_hash',
    ];

    public function attr_carrinho()
    {
        return $this->belongsToMany('App\Models\Attr_carrinho', 'attr_carrinho', 'aux_carrinho_id', 'atributo_id');
    }
}
