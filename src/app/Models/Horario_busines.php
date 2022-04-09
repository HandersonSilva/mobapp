<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Horario_busines extends Model
{
    //
    protected $fillable = [
        'dia',
        'inicio',
        'fechamento',
        'obs',
        'status',
        'busines_id',
    ];

    public function busines()
    {
        return $this->belongsTo(Busine::class);

    }
}
