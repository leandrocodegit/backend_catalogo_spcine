<?php

namespace App\Models\Catalogo;

use App\Models\Account\User;
use App\Models\Enums\StatusAgenda;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Agenda extends Model
{
    use HasFactory;

    protected $table = "agendas";

    protected $fillable = [
        'catalogo_id',
        'data',
        'status',
        'user_id',
        'valor'
    ];

    public function getStatusAttribute()
    {
        return StatusAgenda::from($this->attributes['status'])->name;
    }
    public function catalogo(){
        return $this->belongsTo(Catalogo::class);
    }

    public function user(){
        return $this->belongsTo(User::class);
    }
}
