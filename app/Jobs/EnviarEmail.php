<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Mail\NotificacaoEmail;
use Illuminate\Support\Facades\Mail; 

class EnviarEmail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;


    private $user;
    private $tokenAccess;
    private $tipo;
 
    public function __construct($user, $tokenAccess, $tipo)
    {
        $this->user = $user;
        $this->tokenAccess = $tokenAccess;
        $this->tipo = $tipo;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    { 
        Mail::to($this->user->email)->send(new NotificacaoEmail($this->user, $this->tokenAccess, $this->tipo));            
    }
}
