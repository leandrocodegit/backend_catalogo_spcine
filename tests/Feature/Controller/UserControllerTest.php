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
use Illuminate\Testing\Fluent\AssertableJson;

class UserControllerTest extends TestCase
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
       
        $this->token = 'Bearer ' .JWTAuth::fromUser($this->user);  
    }
 
    public function test_create_novo_usuario()
    {
 
        $response = $this->withHeaders([
            'Authorization' =>  $this->token,
        ])->post('/api/user', 
        [  
            "nome" => "Leandro",
            "cpf" => "08987782635",
            "email" => "lpoliveira@gmail.com",
            "empresa" => "Spcine",
            "password" => "Pass2020!",
            "password_confirmation" => "Pass2020!",
            "perfil"  => [
                "id" => 1,
                "role" => "ADMIN",
                "nome" => "Administrador"
            ]
        ]); 
 
        $response->assertStatus(200);
    }

    public function test_create_novo_password_invalido_usuario()
    {
 
        $response = $this->withHeaders([
            'Authorization' =>  $this->token,
        ])->post('/api/user', 
        [  
            "nome" => "Leandro",
            "cpf" => "08987782635",
            "email" => "lpoliveira@gmail.com",
            "empresa" => "Spcine",
            "password" => "Fake20!",
            "password_confirmation" => "Fake20!",
            "perfil"  => [
                "id" => 1,
                "role" => "ADMIN",
                "nome" => "Administrador"
            ]
        ]); 
 
        $response->assertStatus(400);
    }

    public function test_create_novo_password_invalido_letras_usuario()
    {
 
        $response = $this->withHeaders([
            'Authorization' =>  $this->token,
        ])->post('/api/user', 
        [  
            "nome" => "Leandro",
            "cpf" => "08987782635",
            "email" => "lpoliveira@gmail.com",
            "empresa" => "Spcine",
            "password" => "12345678!",
            "password_confirmation" => "12345678!",
            "perfil"  => [
                "id" => 1,
                "role" => "ADMIN",
                "nome" => "Administrador"
            ]
        ]); 
 
        $response->assertStatus(400);
    }


    public function test_atualizar_usuario()
    {
 
        $response = $this->withHeaders([
            'Authorization' =>  $this->token,
        ])->patch('/api/user', 
        [  
            "id" => $this->user->id,
            "nome" => "Fake new",
            "cpf" => "9845213154",
            "email" => "fake@gmail.com",
            "empresa" => "Spcine" 
        ]); 
 
        $response->assertStatus(200);
    }

    public function test_busca_usuario()
    {

        $response = $this->withHeaders([
            'Authorization' => $this->token,
        ])->get('/api/user/' .$this->user->id); 
 
        $response->assertStatus(200);
    }

    public function test_busca_usuario_not_exists()
    {

        $response = $this->withHeaders([
            'Authorization' => $this->token,
        ])->get('/api/user/40'); 
 
        $response->assertStatus(202);
    }

    public function test_delete_usuario()
    {

        $response = $this->withHeaders([
            'Authorization' => $this->token,
        ])->delete('/api/user/' .$this->user->id); 
 
        $response->assertStatus(200);
    }

    public function test_busca_lista_usuario()
    {

        $response = $this->withHeaders([
            'Authorization' => $this->token,
        ])->get('/api/user/filter/list/fake'); 
 
        $response->assertStatus(200);
        $this->assertTrue(count($response->decodeResponseJson()) > 0);
    }

    public function test_busca_lista_usuario_empty_result()
    {

        $response = $this->withHeaders([
            'Authorization' => $this->token,
        ])->get('/api/user/filter/list/x'); 
 
        $response->assertStatus(201);
        $response->assertJson(fn (AssertableJson $json) =>
        $json->where('message', 'Necessário ao menos 3 caracteres!'));
    }

}
