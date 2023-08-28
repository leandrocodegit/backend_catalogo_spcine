<?php

namespace App\Models\Catalogo;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Icon extends Model
{
    use HasFactory;

    protected $table = 'icon_cordenada';

    protected $fillable = [
        'descricao',
        'imagem'
    ];


    protected $appends = array('host', 'count');

    public function getCountAttribute()
    {
        return $this->catalogos()->count();
    }


    public function getHostAttribute()
    {
        return 'storage'. $this->imagem;
    }

    public function catalogos(){
        return $this->hasMany(Catalogo::class);
    }

}
