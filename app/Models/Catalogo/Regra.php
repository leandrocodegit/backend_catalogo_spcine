<?php

namespace App\Models\Catalogo;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Regra extends Model
{
    use HasFactory;

    protected $table = "regras";

    public function catalogos(){
        return $this->hasMany(Catalogo::class);
    }
}
