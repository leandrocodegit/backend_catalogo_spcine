<?php

namespace App\Models\Catalogo;


use Illuminate\Database\Eloquent\Relations\belongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model; 
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Facades\DB;

class Catalogo extends Model
{
    use HasFactory;

    protected $hidden = [
        'regiao_id',
        'cordenadas_id',
        'administrador_id'
    ];

    protected $table = "catalogos";

    public function imagens(){
        return $this->hasMany(Imagem::class)->orderByRaw('ordem and principal desc');
    }

    public function regras(){
        return $this->belongsToMany(Regra::class, 'regras_catalogo');
    }

    public function descricoes(){
        return $this->hasMany(Descricao::class);
    }

    public function precos(){
        return $this->hasMany(Preco::class);
    }

    public function tags(){
        return $this->belongsToMany(Tag::class, 'tags_catalogo');
    }

    public function regiao(){
        return $this->belongsTo(Regiao::class);
    }

    public function administrador(){
        return $this->belongsTo(Administrador::class);
    }

    public function cordenadas(){
        return $this->belongsTo(Cordenada::class);
    }
}
