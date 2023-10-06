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

    protected $appends = array('count');

    public function getCountAttribute()
    {
        return $this->catalogos()->count();
    }


    public function catalogos(){
        return $this->hasMany(Catalogo::class, 'categoria_id');
    }

}
