<?php

namespace App\Models\Catalogo;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CategoriaCatalogo extends Model
{
    use HasFactory;

    protected $table = "categoria_catalogo";

    protected $fillable = [
        'nome'
    ];

    protected $hidden = [
        'created_at',
        'updated_at'
    ];

    public function catalogos(){
        return $this->hasMany(Tag::class);
    }
}
