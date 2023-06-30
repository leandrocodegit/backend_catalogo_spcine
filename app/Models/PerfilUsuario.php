<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PerfilUsuario extends Model
{
    use HasFactory;

    protected $table = 'perfil_usuario';

    protected $fillable = [
        'id',
        'role',
        'nome' 
    ];

    public function usuario
    (){
        return $this->belongsTo(Usuario::class);
    }
}
