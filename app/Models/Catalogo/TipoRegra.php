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
        'nome'  
    ];

    protected $hidden = [
        'created_at',
        'updated_at' 
    ];

    public function regras(){
        return $this->hasMany(Regra::class);
    }
}
