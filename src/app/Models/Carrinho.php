<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Carrinho extends Model
{

    protected $fillable = [
        'valor_total_prod',
        'user_id',
        'busine_id',
        'faturado',
    ];

    public $timestamps = false;

    public function produto()
    {
        return $this->belongsToMany('App\Models\Produto', 'aux_carrinho_produtos', 'carrinho_id', 'produto_id');
    }

    public function promocao()
    {
        return $this->belongsToMany('App\Models\Promocao', 'aux_carrinho_promocaos', 'carrinho_id', 'promocao_id');
    }

    public function pedido()
    {
        return $this->belongsToMany('App\Models\Pedidos', 'aux_pedido_carrinhos', 'carrinho_id', 'pedidos_id');
    }

}
