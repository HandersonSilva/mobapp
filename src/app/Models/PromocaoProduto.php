<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PromocaoProduto extends Model
{
    protected $table = 'promocao_produto';
    public $timestamps = false;

    protected $fillable = [
        'promocao_id',
        'produto_id',
    ];
}
