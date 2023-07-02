<?php
  
namespace App\Enums;
 
enum StatusAgenda: string  {
    case DISPONIVEL = 'pending';
    case BLOQUEADA = 'active';
    case RESERVADA = 'inactive'; 
}