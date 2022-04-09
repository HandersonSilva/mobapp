<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Promocao extends Model
{

    protected $fillable = [
        'title_promocao',
        'decricao_promocao',
        'valor_total',
        'estoque_promocao',
        'ativo',
        'urlImg_promocao',
    ];

    public $timestamps = false;
    protected $table = 'promocoes';

    public function produtos()
    {
        return $this->belongsToMany('App\Models\Produto', 'promocao_produto', 'promocao_id', 'produto_id');
    }

    public function promocao()
    {
        return $this->belongsToMany('App\Models\Carrinho', 'aux_carrinho_promocaos', 'promocao_id', 'carrinho_id');
    }
}
