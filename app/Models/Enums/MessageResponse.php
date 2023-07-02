<?php
  
namespace App\Models\Enums;
 
enum MessageResponse: string  {
    case SUCCESS_UPDATE = 'Dados atualizados com sucesso!';
    case SUCCESS_CREATE = 'Dados salvos com sucesso!';
    case NOT_FOUND = 'Nenhum resultado encontrado!';
    case ERROR = 'Um erro ocorreu!'; 
}