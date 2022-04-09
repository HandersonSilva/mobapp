<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class Cartao extends Model
{
   
    protected $table = 'cartoes';

    protected $fillable = [
        'card_name',
        'card_number',
        'card_flag',
        'card_expiration',
        'user_id'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
