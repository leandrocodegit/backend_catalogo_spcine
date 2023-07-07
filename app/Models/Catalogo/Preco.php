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
        'valor',
        'catalogo_id'  
    ];

    protected $hidden = [
        'catalogo_id'
    ];

    public function catalogo(){
        return $this->belongsTo(Catalogo::class);
    }
}
