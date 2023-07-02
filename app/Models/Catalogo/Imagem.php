<?php

namespace App\Models\Catalogo;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Catalogo;

class Imagem extends Model
{
    use HasFactory;
    protected $table = "imagens";

    protected $hidden = [
        'catalogo_id'  
    ];

    public function catalogo(){
        return $this->belongsTo(Catalogo::class);
    }
}
