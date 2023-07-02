<?php

namespace Tests\Feature\Controller;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Account\User;
use App\Models\Account\PerfilUsuario;
use App\Models\Account\EmailSubject; 
use App\Models\Account\TokenAccess; 
use Mockery\MockInterface;
use App\Jobs\EnviarEmail;
use Illuminate\Support\Facades\Auth;
use Tymon\JWTAuth\Facades\JWTAuth;
use Database\Factories\Account\TokenAccessCheckFactory;

class SecurityControllerNotAuthTest extends TestCase
{
    
    use RefreshDatabase;

    private string $token;
    protected $perfil;
    protected $user;
    protected $tokenAccess;

    public function setUp(): void
    {
        parent::setUp(); 
        $this->perfil = PerfilUsuario::factory()->create();
        $this->user = User::factory()->create();
        $this->tokenAccess = TokenAccess::factory()->create();
        
    }

    // Alterar senha não autenticado
 
    public function test_alterar_password_valid_not_auth_usuario()
    {
        $response = $this->put('/api/user/reset/password', 
        [   
            "id" => 1,
            "token" =>  $this->tokenAccess->token,
            "password" => "F@kePassword10!",
            "password_confirmation" => "F@kePassword10!", 
        ]);          
 
        $response->assertStatus(401);
         
    }
 
}
