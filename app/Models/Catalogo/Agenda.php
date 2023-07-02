<?php

namespace App\Models\Catalogo;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Agenda extends Model
{
    use HasFactory;

    protected $table = "agendas";

    public function catalogo(){
        return $this->belongsTo(Catalogo::class);
    }
}
