<?php

namespace App\Models\Catalogo;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cordenada extends Model
{
    use HasFactory;

    protected $table = "cordenadas";

    protected $fillable = [
        'latitude',
        'longitude',
        'icon_id'
    ];

    protected $hidden = [
        'created_at',
        'updated_at'
    ];

    public function catalogo(){
        return $this->belongsTo(Catalogo::class);
    }



}
