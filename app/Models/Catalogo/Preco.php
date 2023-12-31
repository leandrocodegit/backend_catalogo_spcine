<?php

namespace App\Models\Catalogo;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Preco extends Model
{
    use HasFactory;

    protected $table = "precos";

    protected $fillable = [
        'descricao',
        'minimo',
        'maximo',
        'descontos',
        'tabela_descontos',
        'tabela_precos',
        'catalogo_id'
    ];

    public function catalogo(){
        return $this->belongsTo(Catalogo::class);
    }
}
