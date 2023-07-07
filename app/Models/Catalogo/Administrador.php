<?php

namespace App\Models\Catalogo;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Administrador extends Model
{
    use HasFactory;

    protected $table = "administrador_catalogo";

    protected $hidden = [
        'catalogo_id',
        'created_at',
        'updated_at' 
    ];
 
    public function catalogo(){
        return $this->belongsTo(Catalogo::class);
    }
}
