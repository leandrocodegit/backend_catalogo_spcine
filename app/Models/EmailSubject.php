<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmailSubject extends Model
{
    use HasFactory;

    public $mensagem;
    public $nameBottom;
    public $link;
    public $assunto;
}
