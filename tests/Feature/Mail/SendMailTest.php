<?php

namespace Tests\Feature\Mail;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Mail\NotificacaoEmail;
use Illuminate\Support\Facades\Mail;
use App\Models\Account\User;
use App\Models\Account\PerfilUsuario;
use App\Models\Account\EmailSubject;  
use App\Models\Account\TokenAccess; 
use Illuminate\Support\Str;  
use Carbon\Carbon;

class SendMailTest extends TestCase
{
    private string $tokenAccess;
    protected $perfil;
    protected $user;

    public function setUp(): void
    {
        parent::setUp(); 
        $this->perfil = PerfilUsuario::factory()->create();
        $this->user = User::factory()->create();       

        $this->tokenAccess = TokenAccess::factory()->create();
    }
    public function test_send_notificacao_email(): void
    {
        Mail::fake();
        $notificacaoEmail = new NotificacaoEmail($this->user, new TokenAccess, 'TEST');         

        Mail::assertNothingSent(); 
       
    }
}
