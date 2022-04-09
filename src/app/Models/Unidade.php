<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Unidade extends Model
{
       protected $fillable = [
        'id',
        'sigla',
        'nome',
        'busine_id'
    ];

    public $timestamps = false;

    public function busine(){
        return $this->belongsTo(Busine::class);
   }
}
