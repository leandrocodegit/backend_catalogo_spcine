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
        'nome'  
    ];

    public function catalogos(){
        return $this->belongsToMany(Catalogo::class, 'tags_catalogo');
    }
}
