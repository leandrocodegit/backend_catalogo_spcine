<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str; 

use App\Models\Account\User;
use App\Models\Account\EmailSubject;

class NotificacaoEmail extends Mailable 
    {
        use Queueable, SerializesModels;    
 
        private $user;
        private $emailSubject; 

        public function __construct($user, $tokenAccess, $tipo)
        {
            $this->emailSubject = new EmailSubject; 
            $this->user = $user;
            
            if($tipo === 'CHECK'){ 
                $this->emailSubject->mensagem = 'Olá ' .$user->nome .', ative sua conta Spcine agora.';
                $this->emailSubject->nameBottom = 'Ativar conta';
                $this->emailSubject->assunto =  'Ative sua conta';
                $this->emailSubject->link =   env('APP_URL') .'/account/active/' .$this->user->id .'/'. $tokenAccess->token; 
            }
            else if($tipo === 'RESET'){ 
                $this->emailSubject->mensagem = 'Olá ' .$user->nome .', foi solicitado a redefinição de senha na sua conta Spcine.';
                $this->emailSubject->nameBottom = 'Redefinir senha';
                $this->emailSubject->assunto =  'Redefinição de senha';
                $this->emailSubject->link =  env('APP_URL') .'/account/reset/' .$this->user->id .'/'. $tokenAccess->token; 
            } 
            // Define para teste de unidade
            else if($tipo === 'TEST'){ 
                $this->emailSubject->mensagem = 'test';
                $this->emailSubject->nameBottom = 'test';
                $this->emailSubject->assunto =  'test';
                $this->emailSubject->link =  'test'; 
            } 
        }
 
        public function envelope()
        {
            return new Envelope(
                subject: $this->emailSubject->assunto,
            );
        }
 
        public function build()
        { 
            return $this->view('mail')->with(
                ['user' => $this->user, 
                'emailSubject' => $this->emailSubject]);
        }
 
        public function attachments()
        {
            return [];
        }
    }
    