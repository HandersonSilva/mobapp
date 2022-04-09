<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class Address extends Model
{
    protected $table = "address";

    protected $fillable = [
        'cidade',
        'UF',
        'bairro',
        'rua',
        'cep',
        'numero',
        'lat_user',
        'log_user',
        'user_id'
    ];

    public function user(){
        return $this->belongsTo(User::class);
    }

}
