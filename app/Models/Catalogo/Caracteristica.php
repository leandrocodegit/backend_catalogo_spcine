<?php

namespace App\Models\Catalogo;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Caracteristica extends Model
{
    use HasFactory;

    protected $table = "caracteristicas";

    protected $fillable = [
        'id',
        'nome',
        'categoria_id'
    ];

    protected $hidden = [
        'categoria_id'
    ];

    protected $appends = ['count', 'categoria'];

    public function getCountAttribute()
    {
        return $this->catalogos()->count();
    }


    public function getCategoriaAttribute()
    {
        return [
                'id' => $this->categoria()->first()->id,
                'nome' => $this->categoria()->first()->nome,
        ];
    }
    public function catalogos(){
        return $this->belongsToMany(Catalogo::class, 'caracteristicas_catalogo');
    }

    public function categoria(){
        return $this->belongsTo(CategoriaCaracteristica::class, 'categoria_id');
    }
}
