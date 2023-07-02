<?php

namespace App\Models\Catalogo;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Descricao extends Model
{
    use HasFactory;

    protected $table = "descricoes_catalogo";

    public function catalogo(){
        return $this->belongsTo(Catalogo::class);
    }
}
