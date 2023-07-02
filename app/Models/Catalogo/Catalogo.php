<?php

namespace App\Models\Catalogo;


use Illuminate\Database\Eloquent\Relations\belongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model; 
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Catalogo extends Model
{
    use HasFactory;

    protected $hidden = [
        'regiao_id' 
    ];

    protected $table = "catalogos";

    public function imagens(){
        return $this->hasMany(Imagem::class);
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

    public function Regiao(){
        return $this->belongsTo(Regiao::class);
    }
}
