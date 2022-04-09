<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Busine;

class Busine_endereco extends Model
{
    //
    protected $table = "busine_enderecos";

    protected $fillable = [
        'cidade',
        'bairro',
        'rua',
        'cep',
        'numero',
        'lat_empresa',
        'log_empresa'
    ];

    public function busine(){
        return $this->belongsTo(Busine::class);
    }

}
