<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Atributo;

class CategoriaAtributo extends Model
{
    protected $fillable = [
        'id',
        'nome_categ_atrib',
        'permite_duplic',
        'busine_id'
    ];

    public $timestamps = false;
    protected  $table = 'categoria_atributo';

    public function atributos(){
          return $this->hasMany(Atributo::class);
    }
}
