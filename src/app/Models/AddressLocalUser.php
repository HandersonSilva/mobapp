<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AddressLocalUser extends Model
{
    //
    protected $table = "address_local_users";

    protected $fillable = [
        "user_id",
        "num",
        "rua_long",
        "rua_short",
        "bairro_long",
        "bairro_short",
        "cidade_long",
        "cidade_short",
        "estado_long",
        "estado_short",
        "pais_long",
        "pais_short",
        "cep_long",
        "endereco_format",
        "lat",
        "lng",
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
