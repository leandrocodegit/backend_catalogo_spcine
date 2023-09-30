<?php

namespace App\Models\Catalogo;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Regra extends Model
{
    use HasFactory;

    protected $table = "regras";

    protected $fillable = [
        'tipo_id',
        'descricao',
        'imagem'
    ];

    protected $hidden = [
        'imagem',
        'pivot'
    ];

    protected $appends = array('host', 'count', 'tipo', 'text');

    public function getHostAttribute()
    {
        return ENV('APP_URL_REGRAS'). $this->imagem;
    }

    public function getTipoAttribute()
    {
        return [
            'id' => $this->tipo()->first()->id,
            'nome' => $this->tipo()->first()->nome,
            'destaque' => $this->tipo()->first()->destaque
        ];
    }
    public function getCountAttribute()
    {
        return $this->catalogos()->count();
    }

    public function getTextAttribute()
    {
        $svgContent = \Illuminate\Support\Facades\Storage::disk('public')->get($this->imagem);
        return response($svgContent, 200)->header('Content-Type', 'text')->original;
    }

    public function catalogos(){
        return $this->belongsToMany(Catalogo::class, 'regras_catalogo');
    }

    public function tipo(){
        return $this->belongsTo(TipoRegra::class, 'tipo_id');
    }
}
