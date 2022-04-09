<?php

namespace App\Models;

use Tymon\JWTAuth\Contracts\JWTSubject;
use App\Models\Address;
use App\Models\Cartao;
use App\Models\Permission;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

//use Illuminate\Auth\Authenticatable as AuthenticableTrait;
class User extends Authenticatable  implements JWTSubject
{
    use  Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'nome', 'email', 'password', 'cpf', 'telefone', 'hash_google', 'distancia','url_img_perfil','activate_account'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function address()
    {
        return $this->hasMany(Address::class);
    }

    public function addressLocal()
    {
        return $this->hasMany(AddressLocalUser::class);
    }

    public function cartoes()
    {
        return $this->hasMany(Cartao::class);
    }


       /**
     * Get the identifier that will be stored in the subject claim of the JWT.
     *
     * @return mixed
     */
    public function getJWTIdentifier(){
        return $this->getKey();
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims(){
        return [];
    }
    
}
