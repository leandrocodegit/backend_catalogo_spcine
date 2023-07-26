<?php

namespace App\Models\Catalogo;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Regra extends Model
{
    use HasFactory;

    protected $table = "regras";

    protected $fillable = [
        'tipo_id',
        'descricao',
        'imagem'
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
        'pivot'
    ];

    protected $appends = array('host', 'count');

    public function getHostAttribute()
    {
        return env('URL_FILE'). $this->imagem;
    }

    public function getCountAttribute()
    {
        return $this->catalogos()->count();
    }

    public function catalogos(){
        return $this->belongsToMany(Catalogo::class, 'regras_catalogo');
    }

    public function tipo(){
        return $this->belongsTo(TipoRegra::class, 'tipo_id');
    }
}
