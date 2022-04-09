<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Attr_carrinho extends Model
{
    //
    //  protected $table = 'attr_carrinho';
    //  public $timestamps = false;

    protected $fillable = [
        'aux_carrinho_id',
        'atributo_id',
        'atributo_qtd'
    ];
}
