<?php

namespace App\Models\Catalogo;


use Illuminate\Database\Eloquent\Relations\belongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model; 
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Catalogo extends Model
{
    use HasFactory;

    protected $table = "catalogos";

 
 
}
