<?php

namespace App\Models\Catalogo;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TipoRegra extends Model
{
    use HasFactory;

    protected $table = 'tipo_regra';

    protected $fillable = [
        'id',
        'nome',
        'destaque'
    ];

    protected $appends = array('count');

    public function getCountAttribute()
    {
        return $this->regras()->count();
    }

    public function regras(){
        return $this->hasMany(Regra::class, 'tipo_id');
    }
}
