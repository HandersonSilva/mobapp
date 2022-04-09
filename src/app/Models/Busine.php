<?php

namespace App\Models;

use App\Models\Categoria;
use Illuminate\Database\Eloquent\Model;
use App\Models\Busine_endereco;
use App\Models\Busine_config;

class Busine extends Model
{
    protected $table = 'busines';

    protected $fillable = [
        'nome',
        'nome_fantasia',
        'docs',
        'telefone',
        'seguimento',
        'url_img_busine',
        'busine_configs_id',
        'busine_enderecos_id',
        'admin_id'

    ];

    public function busineConfig()
    {
        return $this->belongsTo(Busine_config::class);
    }

    public function busineAddress()
    {
        return $this->belongsTo(Busine_endereco::class);
    }
    
    public function busineAdmin()
    {
        return $this->belongsTo(Admin::class, 'admin_id');
    }

    public function categorias()
    {
        return $this->hasMany(Categoria::class);
    }

}
