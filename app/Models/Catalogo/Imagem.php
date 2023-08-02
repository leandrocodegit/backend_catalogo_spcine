<?php

namespace App\Models\Catalogo;

use App\Models\Enums\StatusAgenda;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Catalogo\Catalogo;

class Imagem extends Model
{
    use HasFactory;
    protected $table = "imagens";

    protected $fillable = [
        'titulo',
        'descricao',
        'ordem',
        'principal',
        'url',
        'originalExtension',
        'originalName',
        'hashName',
        'catalogo_id'
    ];

    protected $appends = array('host');

    protected $hidden = [

    ];

    public function getHostAttribute()
    {
       // return env('URL_FILE'). $this->url;
        return $this->url;
    }

    public function catalogo(){
        return $this->belongsTo(Catalogo::class, 'catalogo_id');
    }
}
