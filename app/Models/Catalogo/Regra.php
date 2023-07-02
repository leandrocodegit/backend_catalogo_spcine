<?php

namespace App\Models\Catalogo;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Regra extends Model
{
    use HasFactory;

    protected $table = "regras";
    
    protected $hidden = [
        'created_at',
        'updated_at',
        'pivot'
    ];

    public function catalogos(){
        return $this->belongsToMany(Catalogo::class, 'regras_catalogo');
    }
}
