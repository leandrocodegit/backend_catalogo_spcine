<?php

namespace App\Models\Catalogo;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class CaracteristicasCatalogo extends Model
{
    use HasFactory;

    protected $table = "caracteristicas_catalogo";

    protected $fillable = [
        'caracteristica_id',
        'catalogo_id'
    ];

}
