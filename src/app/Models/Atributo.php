<?php

namespace App\Models;

use App\Models\CategoriaAtributo;
use App\Models\Produto;
use Illuminate\Database\Eloquent\Model;

class Atributo extends Model
{
    protected $fillable = [
        'nome_atributo',
        'valor_atributo',
        'disponibilidade',
        'qtd_max',
        'produto_id',
        'categoria_atributo_id',
    ];

    public $timestamps = false;

    public function produto()
    {
        return $this->belongsTo(Produto::class);
    }

    public function categoriaAtributo()
    {
        return $this->belongsTo(CategoriaAtributo::class);
    }

    public function aux_carrinho()
    {
        return $this->belongsToMany('App\Models\Aux_carrinho_produto', 'attr_carrinho', 'atributo_id', 'aux_carrinho_id');
    }

}
