<?php

namespace App\Models;

use App\Models\Address;
use App\Permission;
use App\Role;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;
use Validator;

class Admin extends Authenticatable
{
    use HasApiTokens, Notifiable;

    protected $table = 'admins';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id','nome', 'email', 'password', 'telefone','hash_activate', 'activate_account','distancia', 'code_expires'
    ];


    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function roles()
    {
        return $this->belongsToMany(\App\Role::class);

    }
    public function hasPermission(Permission $permission)
    {
        return $this->hasAnyRoles($permission->roles);

    }

    public function hasAnyRoles($roles)
    {
        if (is_array($roles) || is_object($roles)) {
            // Log::debug(var_dump($this->roles));
            return !!$roles->intersect($this->roles)->count();
        }

        return $this->roles->contains('name', $roles);
    }

    public function address()
    {
        return $this->hasMany(Address::class);
    }

    public function busine()
    {
        return $this->hasMany(Busine::class,'admin_id');
    }

}
