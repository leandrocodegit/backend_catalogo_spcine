<?php

namespace App\Models\Catalogo;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CategoriaCaracteristica extends Model
{
    use HasFactory;

    protected $table = "categoria_caracteristicas";

    protected $fillable = [
        'nome'
    ];

    protected $appends = array('count');

    public function getCountAttribute()
    {
        return $this->caractericticas()->count();
    }

    public function caractericticas(){
        return $this->hasMany(Caracteristica::class, 'categoria_id');
    }
}
