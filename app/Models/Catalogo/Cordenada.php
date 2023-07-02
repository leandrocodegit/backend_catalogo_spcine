<?php

namespace App\Models\Catalogo;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cordenada extends Model
{
    use HasFactory;

    protected $table = "cordenadas";
 
    public function catalogo(){
        return $this->belongsTo(Catalogo::class);
    }
}
