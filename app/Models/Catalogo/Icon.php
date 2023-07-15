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

    protected $hidden = [
        'created_at',
        'updated_at'
    ];

    protected $appends = array('host');

    public function getHostAttribute()
    {
        return env('URL_FILE'). $this->imagem;
    }

}
