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


class RegiaoControllerTest extends FactoryConfig
{


    public function test_list_regioes_catalogo()
    {

        $response = $this->withHeaders([
            'Authorization' =>  $this->token,
        ])->get('/api/regiao/list');

        $response->assertStatus(200);
        $this->assertTrue(count($response->decodeResponseJson()) > 0);
    }

    public function test_create_nova_regiao_catalogo()
    {
        $response = $this->withHeaders([
            'Authorization' =>  $this->token,
        ])->post('/api/regiao',
            [
                'nome' => 'regiao test'
            ]);

        $response->assertStatus(200);
    }

    public function test_busca_regiao_por_id()
    {
        $response = $this->withHeaders([
            'Authorization' =>  $this->token,
        ])->get('/api/regiao/' .$this->regiao->id);

        $response->assertStatus(200);
    }

    public function test_busca_regiao_por_id_not_exits()
    {
        $response = $this->withHeaders([
            'Authorization' =>  $this->token,
        ])->get('/api/regiao/2');

        $response->assertStatus(404);
    }

    public function test_atualizar_regiao_catalogo()
    {
        $response = $this->withHeaders([
            'Authorization' =>  $this->token,
        ])->post('/api/regiao',
            [
                'id' => $this->regiao->id,
                'nome' => 'response'
            ]);

        $response->assertStatus(200);

        $response = $this->withHeaders([
            'Authorization' =>  $this->token,
        ])->get('/api/regiao/' .$this->regiao->id);

        $response->assertStatus(200);
        $response->assertJsonPath("nome", "response");
    }

    public function test_delete_regiao_id_vinculado()
    {
        $response = $this->withHeaders([
            'Authorization' =>  $this->token,
        ])->delete('/api/regiao/' .$this->regiao->id);

        $response->assertStatus(404);
    }

    public function test_delete_regiao_id_invalido()
    {
        $response = $this->withHeaders([
            'Authorization' =>  $this->token,
        ])->delete('/api/regiao/100');

        $response->assertStatus(404);
    }

}
