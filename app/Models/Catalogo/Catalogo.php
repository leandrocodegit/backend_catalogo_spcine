<?php

namespace App\Models\Catalogo;


use App\Models\Account\User;
use Illuminate\Database\Eloquent\Relations\belongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Facades\DB;

class Catalogo extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'nome',
        'like',
        'endereco',
        'status',
        'home',
        'active',
        'regiao_id',
        'cordenadas_id',
        'administrador_id',
        'icon_id',
        'categoria_id',
        'user_id',
        'hora_inicial',
        'hora_final',
        'descricao_principal'
    ];

    protected $hidden = [
        'regiao_id',
        'cordenadas_id',
        'administrador_id',
        'icon_id',
        'categoria_id',
        'like'
    ];

    protected $table = "catalogos";

    public function imagens(){
        return $this->hasMany(Imagem::class)->orderByRaw('principal desc');
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

    public function caracteristicas(){
        return $this->belongsToMany(Caracteristica::class, 'caracteristicas_catalogo');

    }

    public function regiao(){
        return $this->belongsTo(Regiao::class);
    }

    public function responsavel(){
        return $this->belongsTo(User::class, 'user_id');
    }
    public function administrador(){
        return $this->belongsTo(Administrador::class);
    }

    public function cordenadas(){
        return $this->belongsTo(Cordenada::class);
    }

    public function icon(){
        return $this->belongsTo(Icon::class);
    }

    public function categoria(){
        return $this->belongsTo(CategoriaCatalogo::class, 'categoria_id');
    }
}
