<?php

namespace Controller;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\Feature\Controller\FactoryConfig;
use Tests\TestCase;
use Mockery\MockInterface;
use App\Models\catalogo\CategoriaCaracteristica;
use App\Models\Account\PerfilUsuario;
use App\Models\Account\User;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Testing\Fluent\AssertableJson;


class AdministradorControllerTest extends FactoryConfig
{


    public function test_list_administradores_catalogo()
    {

        $response = $this->withHeaders([
            'Authorization' =>  $this->token,
        ])->get('/api/administrador/list');

        $response->assertStatus(200);
        $this->assertTrue(count($response->decodeResponseJson()) > 0);
    }

    public function test_create_novo_administrador_catalogo()
    {
        $response = $this->withHeaders([
            'Authorization' =>  $this->token,
        ])->post('/api/administrador',
            [
                'nome' => 'adminstrador test'
            ]);

        $response->assertStatus(200);
    }

    public function test_busca_administrador_por_id()
    {
        $response = $this->withHeaders([
            'Authorization' =>  $this->token,
        ])->get('/api/administrador/' .$this->administrador->id);

        $response->assertStatus(200);
    }

    public function test_busca_administrador_por_id_not_exits()
    {
        $response = $this->withHeaders([
            'Authorization' =>  $this->token,
        ])->get('/api/adminstrador/2');

        $response->assertStatus(404);
    }

    public function test_atualizar_administrador()
    {
        $response = $this->withHeaders([
            'Authorization' =>  $this->token,
        ])->post('/api/administrador',
            [
                'id' => $this->administrador->id,
                'nome' => 'response'
            ]);

        $response->assertStatus(200);

        $response = $this->withHeaders([
            'Authorization' =>  $this->token,
        ])->get('/api/administrador/' .$this->administrador->id);

        $response->assertStatus(200);
        $response->assertJsonPath("nome", "response");
    }

    public function test_delete_administrador_id_vinculado()
    {
        $response = $this->withHeaders([
            'Authorization' =>  $this->token,
        ])->delete('/api/administrador/' .$this->administrador->id);

        $response->assertStatus(404);
    }

    public function test_deleteadministrador_id_invalido()
    {
        $response = $this->withHeaders([
            'Authorization' =>  $this->token,
        ])->delete('/api/administrador/100');

        $response->assertStatus(404);
    }

}
