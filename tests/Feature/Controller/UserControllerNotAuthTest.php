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

class UserControllerTestNotAuth extends TestCase
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
 
    public function test_create_novo_usuario_not_auth()
    {
 
        $response = $this->post('/api/user', 
        [  
            "nome" => "Leandro",
            "cpf" => "08987782635",
            "email" => "lpoliveira@gmail.com",
            "empresa" => "Spcine",
            "password" => "Pass2020!",
            "perfil"  => [
                "id" => 1,
                "role" => "ADMIN",
                "nome" => "Administrador"
            ]
        ]); 
 
        $response->assertStatus(401);
    }

    public function test_atualizar_usuario_not_auth()
    {
 
        $response = $this->patch('/api/user', 
        [  
            "id" => $this->user->id,
            "nome" => "Fake new",
            "cpf" => "9845213154",
            "email" => "fake@gmail.com",
            "empresa" => "Spcine" 
        ]); 
 
        $response->assertStatus(401);
    }

    public function test_busca_usuario_not_auth()
    {

        $response = $this->get('/api/user/' .$this->user->id); 
 
        $response->assertStatus(401);
    }

    public function test_delete_usuario_not_auth()
    {

        $response = $this->delete('/api/user/' .$this->user->id); 
 
        $response->assertStatus(401);
    }
}
