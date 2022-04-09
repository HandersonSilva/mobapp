<?php

namespace App\Models;

use App\Models\Atributo;
use App\Models\Categoria;
use App\Models\Promocao;
use Illuminate\Database\Eloquent\Model;

class Produto extends Model
{
    protected $fillable = [
        'nome_prod',
        'desc_prod',
        'img_prod_url',
        'status_promo',
        'valor_custo',
        'valor_prod',
        'valor_promocao',
        'possui_attr',
        'disponibilidade',
        'estoque',
        'codigo_barra',
        'qtd_complementos',
        'categoria_id',
        'unidade_id',
        'busine_id'
    ];

    public function categoria()
    {

        return $this->belongsTo(Categoria::class);

    }
    public function unidade()
    {

        return $this->belongsTo(Unidade::class);

    }

    public function carrinho()
    {
        return $this->belongsToMany('App\Models\Carrinho', 'aux_carrinho_produtos', 'produto_id', 'carrinho_id');
    }

    public function promocao()
    {
        return $this->belongsToMany('App\Models\Promocao', 'promocao_produto', 'produto_id', 'promocao_id');
    }

    public function atributos()
    {

        return $this->hasMany('App\Models\Atributo','produto_id');

    }

}
