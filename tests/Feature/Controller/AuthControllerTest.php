<?php

namespace Tests\Feature\Controller;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Mockery\MockInterface;
use App\Jobs\EnviarEmail;
use App\Models\Account\User;
use App\Models\Account\PerfilUsuario;
use App\Models\Account\EmailSubject;  
use Illuminate\Support\Facades\Auth;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthControllerTest extends TestCase
{
    
    use RefreshDatabase;

    private string $token;
    protected $perfil;
    protected $user;

    public function setUp(): void
    {
        parent::setUp(); 
        $this->perfil = PerfilUsuario::factory()->create();
        $this->user = User::factory()->create(); 
    }
 
    public function test_login_valid_usuario()
    { 
        $response = $this->post('/api/auth/login', 
        [   
            "email" => env('EMAIL_FAKE'), 
            "password" => env('PASSWORD'),          
        ]); 
 
        $response->assertStatus(200);
    }
 
}
