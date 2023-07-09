<?php

namespace App\Models\Logs;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LogMessage extends Model
{
    protected $table = 'logs';

    use HasFactory;

   protected $fillable = [
        'mensagem' 
    ];
}
