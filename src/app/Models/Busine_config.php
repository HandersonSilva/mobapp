<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Busine;

class Busine_config extends Model
{
    //
    protected $table = "busine_configs";
    protected  $fillable = [
        'status_busine',
        'status_openCloser',
        'valor_frete',
        'valor_atrr_excedido',
        'delivery_time',
        'fideliza_cliente'
    ];

    public function busine(){
        return $this->belongsTo(Busine::class);
    }
}
