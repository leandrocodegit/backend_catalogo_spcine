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
use Illuminate\Support\Facades\Mail;
use Tymon\JWTAuth\Facades\JWTAuth;
use Database\Factories\Account\TokenAccessCheckFactory;

class SecurityControllerTest extends TestCase
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
       
        $this->token = 'Bearer ' .JWTAuth::fromUser($this->user);  
    }
 
    public function test_forgot_password_usuario()
    {

        Mail::fake();
        
        $response = $this->post('/api/forgot', 
        [   
            "email" => "fake@fake.com" 
        ]);          
 
        $response->assertStatus(200);
         
    }
    
    public function test_forgot_resend_ativar_conta_usuario()
    {
        $response = $this->post('/api/forgot/resend', 
        [   
            "email" => "fake@fake.com" 
        ]);          
 
        $response->assertStatus(200);         
    }

    public function test_forgot_resend_active_conta_activada_usuario()
    {
        $this->user->active = true;
        $this->user->save();
        $response = $this->post('/api/forgot/resend', 
        [   
            "email" => "fake@fake.com" 
        ]);          
 
        $response->assertStatus(400);         
    }

    public function test_forgot_resend_active_conta_email_invalido_usuario()
    {
        $response = $this->post('/api/forgot/resend', 
        [   
            "email" => "fake@invalid.com" 
        ]);          
 
        $response->assertStatus(400);         
    }

    // Alterar senha com link

    public function test_alterar_password_valid_link_usuario()
    {
        $response = $this->put('/api/forgot/reset/password', 
        [   
            "id" => 1,
            "token" =>  $this->tokenAccess->token,
            "password" => "F@kePassword10!",
            "password_confirmation" => "F@kePassword10!", 
        ]);          
 
        $response->assertStatus(200);
         
    }

    
    public function test_alterar_password_invalid_numero_link_usuario()
    {
        $response = $this->put('/api/forgot/reset/password', 
        [   
            "id" => 1,
            "token" =>  $this->tokenAccess->token,
            "password" => "F@kePassword!",
            "password_confirmation" => "F@kePassword!", 
        ]);          
 
        $response->assertStatus(400);         
    }

    public function test_alterar_password_invalid_letras_link_usuario()
    {
        $response = $this->put('/api/forgot/reset/password', 
        [   
            "id" => 1,
            "token" =>  $this->tokenAccess->token,
            "password" => "12345678!",
            "password_confirmation" => "12345678!", 
        ]);          
 
        $response->assertStatus(400);         
    }

    public function test_alterar_password_invalid_simbolo_link_usuario()
    {
        $response = $this->put('/api/forgot/reset/password', 
        [   
            "id" => 1,
            "token" =>  $this->tokenAccess->token,
            "password" => "FakePassword",
            "password_confirmation" => "FakePassword", 
        ]);          
 
        $response->assertStatus(400);         
    }

    public function test_alterar_password_invalid_minimo_link_usuario()
    {
        $response = $this->put('/api/forgot/reset/password', 
        [   
            "id" => 1,
            "token" =>  $this->tokenAccess->token,
            "password" => "P0ss!",
            "password_confirmation" => "P0ss!", 
        ]);          
 
        $response->assertStatus(400);         
    }

    public function test_alterar_password_invalid_confirmacao_link_usuario()
    {
        $response = $this->put('/api/forgot/reset/password', 
        [   
            "id" => 1,
            "token" =>  $this->tokenAccess->token,
            "password" => "FakePassword10!", 
        ]);          
 
        $response->assertStatus(400);         
    }

    public function test_alterar_password_invalid_maiuscula_link_usuario()
    {
  
        $response = $this->put('/api/forgot/reset/password', 
        [   
            "id" => $this->user->id, 
            "password" => "f@kePasswo!",
            "password_confirmation" => "f@kepasswo!!", 
        ]);          
 
        $response->assertStatus(400);         
    }

    public function test_alterar_password_invalid_minuscula_link_usuario()
    {
  
        $response = $this->put('/api/forgot/reset/password', 
        [   
            "id" => $this->user->id, 
            "password" => "F@KEPASS10!",
            "password_confirmation" => "F@KEPASS10!", 
        ]);          
 
        $response->assertStatus(400);         
    }

    // Alterar senha autenticado

    public function test_alterar_password_valid_autenticado_usuario()
    {
  
        $response = $this->withHeaders([
            'Authorization' => $this->token,
        ])->put('/api/user/reset/password', 
        [   
            "id" => $this->user->id, 
            "password" => "F@kePassword10!",
            "password_confirmation" => "F@kePassword10!", 
        ]);          
 
        $response->assertStatus(200);         
    }

    public function test_alterar_password_invalid_numeros_autenticado_usuario()
    {
  
        $response = $this->withHeaders([
            'Authorization' => $this->token,
        ])->put('/api/user/reset/password', 
        [   
            "id" => $this->user->id, 
            "password" => "F@kePasswo!",
            "password_confirmation" => "F@kePasswo!", 
        ]);          
 
        $response->assertStatus(400);         
    }
 
    public function test_alterar_password_invalid_letras_autenticado_usuario()
    {
  
        $response = $this->withHeaders([
            'Authorization' => $this->token,
        ])->put('/api/user/reset/password', 
        [   
            "id" => $this->user->id, 
            "password" => "12345678!",
            "password_confirmation" => "12345678!", 
        ]);          
 
        $response->assertStatus(400);         
    }

    public function test_alterar_password_invalid_maiuscula_autenticado_usuario()
    {
  
        $response = $this->withHeaders([
            'Authorization' => $this->token,
        ])->put('/api/user/reset/password', 
        [   
            "id" => $this->user->id, 
            "password" => "f@kePasswo!",
            "password_confirmation" => "f@kepasswo!!", 
        ]);          
 
        $response->assertStatus(400);         
    }

    public function test_alterar_password_invalid_minuscula_autenticado_usuario()
    {
  
        $response = $this->withHeaders([
            'Authorization' => $this->token,
        ])->put('/api/user/reset/password', 
        [   
            "id" => $this->user->id, 
            "password" => "F@KEPASS10!",
            "password_confirmation" => "F@KEPASS10!", 
        ]);          
 
        $response->assertStatus(400);         
    }

    public function test_alterar_password_invalid_quantidade_caracteres_autenticado_usuario()
    {
  
        $response = $this->withHeaders([
            'Authorization' => $this->token,
        ])->put('/api/user/reset/password', 
        [   
            "id" => $this->user->id, 
            "password" => "F@ke10!",
            "password_confirmation" => "F@ke10!", 
        ]);          
 
        $response->assertStatus(400);         
    }
}
