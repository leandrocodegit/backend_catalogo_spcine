<?php

namespace App\Models\Catalogo;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Tag extends Model
{
    use HasFactory;

    protected $table = "tags";

    protected $fillable = [
        'id',
        'nome',
        'categoria_tag_id'
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
        'categoria_tag_id'
    ];

    public function catalogos(){
        return $this->belongsToMany(Catalogo::class, 'tags_catalogo');
    }

    public function categoria(){
        return $this->belongsTo(CategoriaTag::class, 'categoria_tag_id');
    }
}
