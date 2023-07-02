<?php

namespace App\Models\Catalogo;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CategoriaTag extends Model
{
    use HasFactory;

    protected $table = "categoria_tags";

    protected $fillable = [ 
        'nome'
    ];

    protected $hidden = [
        'created_at',
        'updated_at' 
    ];

    public function tags(){
        return $this->hasMany(Tag::class);
    }
}
