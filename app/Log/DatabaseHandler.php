<?php

 namespace App\Log;
  
 use Monolog\Handler\AbstractProcessingHandler;
 use App\Models\Logs\LogMessage;
 use Illuminate\Support\Str;
  
 class DatabaseHandler extends AbstractProcessingHandler
 {
    /**
     * @inheritDoc
     */
    protected function write(array $logs): void
   {
        
        LogMessage::create([
            'mensagem' => collect($logs)->first()
        ]);
 
    }
}