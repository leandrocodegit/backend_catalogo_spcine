<?php

namespace App\Models\Catalogo;

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

    protected $hidden = [
        'catalogo_id'  
    ];

    public function catalogo(){
        return $this->belongsTo(Catalogo::class);
    }
}
