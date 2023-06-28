<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Tymon\JWTAuth\Contracts\JWTSubject;

class Usuario extends Authenticatable implements JWTSubject
{
    use HasApiTokens, HasFactory, Notifiable; 

    protected $table = 'usuarios';

    protected $fillable = [ 
        'nome',
        'email',
        'password',
        'perfil_id'
    ];

    public function perfil(){
        return $this->belongsTo(PerfilUsuario::class);
    }

    public function getJWTIdentifier()
    {
        return $this->getKey();
    }
 
    public function getJWTCustomClaims()
    {
        return [ 
            'nome' => $this->nome,
            'email' => $this->email,
            'role' => $this->nome 
        ];
    }
}
