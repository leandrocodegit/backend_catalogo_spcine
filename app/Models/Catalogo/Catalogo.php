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
        'like_langue',
        'endereco',
        'home',
        'active',
        'regiao_id',
        'cordenadas_id',
        'administrador_id',
        'icon_id',
        'categoria_id',
        'user_id'
    ];

    protected $hidden = [
        'regiao_id',
        'cordenadas_id',
        'administrador_id',
        'icon_id',
        'categoria_id'
    ];

    protected $table = "catalogos";

    protected $appends = array('countx');


    public function getCountxAttribute()
    {
        $id = [1,2];
        return Catalogo::with('caracteristicas')->whereHas('caracteristicas', function ($query) use ($id) {
            $query->whereIn('id', [4,8]);
        })->count();
    }


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
