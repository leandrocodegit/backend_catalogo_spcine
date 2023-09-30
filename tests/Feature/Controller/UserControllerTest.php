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

class UserControllerTest  extends FactoryAuthConfig
{

    use RefreshDatabase;




    public function test_create_novo_usuario()
    {

        $response = $this->post('/api/user',
        [
            "nome" => "Leandro",
            "documento" => "08987782635",
            "email" => "lpoliveira@gmail.com",
            "empresa" => "Spcine",
            "password" => "Pass2020!",
            "telefone" => "11987782635",
            "password_confirmation" => "Pass2020!",
            "perfil"  => [
                "id" => 1
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
            "documento" => "08987782635",
            "email" => "lpoliveira@gmail.com",
            "empresa" => "Spcine",
            "password" => "Fake20!",
            "password_confirmation" => "Fake20!",
            "perfil"  => [
                "id" => 2
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
            "documento" => "08987782635",
            "email" => "lpoliveira@gmail.com",
            "empresa" => "Spcine",
            "password" => "12345678!",
            "password_confirmation" => "12345678!",
            "perfil"  => [
                "id" => 2
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
            "documento" => "9845213154",
            "email" => "fake@gmail.com",
            "empresa" => "Spcine",
            "telefone" => "11987782635",
            "celular" => "11987782635"
        ]);

        $response->assertStatus(200);
    }

    public function test_atualizar_perfil_usuario_para_guest()
    {

        $response = $this->withHeaders([
            'Authorization' =>  $this->token,
        ])->patch('/api/user/perfil/update',
            [
                "id" => $this->user->id,
                "perfil"  => [
                    "id" => 3
                ]
            ]);

        $response->assertStatus(200);
    }

    public function test_atualizar_perfil_usuario_para_root()
    {

        $response = $this->withHeaders([
            'Authorization' =>  $this->token,
        ])->patch('/api/user/perfil/update',
            [
                "id" => $this->user->id,
                "perfil"  => [
                    "id" => 1000
                ]
            ]);

        $response->assertStatus(403);
    }

    public function test_ativar_usuario()
    {

        $response = $this->withHeaders([
            'Authorization' =>  $this->token,
        ])->patch('/api/user/status/update/1');

        $response->assertStatus(200);
    }

    public function test_atualizar_perfil_usuario_sem_id()
    {

        $response = $this->withHeaders([
            'Authorization' =>  $this->token,
        ])->patch('/api/user/perfil/update',
            [
                "perfil"  => [
                    "id" => 1
                ]
            ]);

        $response->assertStatus(400);
    }
    public function test_atualizar_perfil_usuario_sem_perfil_id()
    {

        $response = $this->withHeaders([
            'Authorization' =>  $this->token,
        ])->patch('/api/user/perfil/update',
            [
                "id" => $this->user->id
            ]);

        $response->assertStatus(400);
    }


    public function test_busca_usuario()
    {

        $response = $this->withHeaders([
            'Authorization' => $this->token,
        ])->get('/api/user/' .$this->user->id);

        $response->assertStatus(200);
        $response->assertJsonPath("nome", env('NOME_FAKE'));
    }

    public function test_busca_usuario_nao_existe()
    {

        $response = $this->withHeaders([
            'Authorization' => $this->token,
        ])->get('/api/user/40' .$this->user->id);

        $response->assertStatus(404);
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
        ])->post('/api/user/filter/list',
            [
                "nome"  => 'fake'
            ]);
        $response->assertStatus(200);
        $this->assertTrue(count($response->decodeResponseJson()) > 0);
    }

    public function test_busca_lista_usuario_sem_resultados()
    {

        $response = $this->withHeaders([
            'Authorization' => $this->token,
        ])->post('/api/user/filter/list',
            [
                "nome"  => 'x'
            ]);

        $response->assertStatus(201);
        $response->assertJson(fn (AssertableJson $json) =>
        $json->where('message', 'Necessário ao menos 3 caracteres!'));
    }

}
