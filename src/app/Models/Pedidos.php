<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pedidos extends Model
{
    //
    protected $fillable = [
        'codigo',
        'name_empresa',
        'date_inicio',
        'date_fim',
        'hora_inicio',
        'hora_fim',
        'status',
        'status_cancelado',
        'hora_cancelamento',
        'motivo_cancelamento',
        'endereco',
        'busines_id',
        'user_id',
        'formas_id',
    ];

    public function busines()
    {
        return $this->belongsTo(Busine::class);
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function formasPagamento()
    {
        return $this->belongsTo(FormasPagamento::class); //pegar o id do produto para class de carrinho
    }

    public function carrinho()
    {
        return $this->belongsToMany('App\Models\Carrinho', 'aux_pedido_carrinhos', 'pedidos_id', 'carrinho_id');
    }
}
