<?php

namespace App\Models\Catalogo;


use Illuminate\Database\Eloquent\Relations\belongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model; 
class Catalogo extends Model
{
    use HasFactory;

    public function imagens(){
        return $this->hasMany(Imagem::class);
    }
}
