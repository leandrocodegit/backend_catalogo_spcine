<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Tymon\JWTAuth\Contracts\JWTSubject;

class User extends Authenticatable implements JWTSubject
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $table = "users";
 
    protected $fillable = [
        'id',
        'nome',
        'cpf',
        'empresa',
        'email',
        'password',
        'active',
        'perfil_id' 
    ];
 
    protected $hidden = [
        'password',
        'remember_token',
        'perfil_id'
    ];
 
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    use Notifiable;
 
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }
 
    public function getJWTCustomClaims()
    {
        return [ 
            'nome' => $this->nome,
            'email' => $this->email,
            'role' => $this->perfil->role
        ];
    }

    public function perfil(){
        return $this->belongsTo(PerfilUsuario::class);
    }

}
