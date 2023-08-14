<?php

namespace App\Models\Catalogo;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Regiao extends Model
{
    use HasFactory;

    protected $table = "regioes";

    protected $fillable = [
        'nome'
    ];

    protected $appends = array('count');

    public function getCountAttribute()
    {
        return $this->catalogos()->count();
    }

    public function catalogos(){
        return $this->hasMany(Catalogo::class);
    }
}
