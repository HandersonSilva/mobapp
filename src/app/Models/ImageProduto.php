<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ImageProduto extends Model
{
    //
    protected $fillable = [
        'id',
        'nome',
        'imagem_padrao',
        'produto_id'
    ];

    public function produto()
    {
        return $this->belongsTo(Produto::class);
    }
}
