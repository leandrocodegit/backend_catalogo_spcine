<?php

namespace App\Models\Catalogo;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class RegrasCatalogo extends Model
{
    use HasFactory;

    protected $table = "regras_catalogo";

    protected $fillable = [
        'regra_id',
        'catalogo_id'
    ];

}
