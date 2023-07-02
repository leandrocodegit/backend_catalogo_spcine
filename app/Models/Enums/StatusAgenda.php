<?php
  
namespace App\Models\Enums;
 
final class StatusAgenda extends Enum
 {
    const  DISPONIVEL = 'pending';
    const  BLOQUEADA = 'active';
    const  RESERVADA = 'inactive'; 
}