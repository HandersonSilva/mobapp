<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Produto;
use App\Models\Busine;

class Categoria extends Model
{
    protected $fillable = [
        'nome_categ',
        'busine_id'
    ];

    public $timestamps = false;

    public function produtos(){
         return $this->hasMany(Produto::class);
    }

    public function busine(){
        return $this->belongsTo(Busine::class);
   }
}
