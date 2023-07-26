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

    protected $appends = array('count');

    public function getCountAttribute()
    {
        return $this->catalogos()->count();
    }
    public function catalogos(){
        return $this->hasMany(Catalogo::class, 'administrador_id');
    }
}
