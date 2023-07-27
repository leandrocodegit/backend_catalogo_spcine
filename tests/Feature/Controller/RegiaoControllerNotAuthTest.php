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


class RegiaoControllerNotAuthTest extends FactoryConfig
{


    public function test_list_regioes_catalogo()
    {

        $response = $this->get('/api/regiao/list');

        $response->assertStatus(401);
    }

    public function test_create_nova_regiao_catalogo()
    {
        $response = $this->post('/api/regiao',
            [
                'nome' => 'regiao test'
            ]);

        $response->assertStatus(401);
    }

    public function test_busca_regiao_por_id()
    {
        $response = $this->get('/api/regiao/' .$this->regiao->id);

        $response->assertStatus(401);
    }

    public function test_busca_regiao_por_id_not_exits()
    {
        $response = $this->get('/api/regiao/2');

        $response->assertStatus(401);
    }

    public function test_atualizar_regiao_catalogo()
    {
        $response = $this->post('/api/regiao',
            [
                'id' => $this->regiao->id,
                'nome' => 'response'
            ]);

        $response->assertStatus(401);
    }

    public function test_delete_regiao_id_vinculado()
    {
        $response = $this->delete('/api/regiao/' .$this->regiao->id);

        $response->assertStatus(401);
    }

    public function test_delete_regiao_id_invalido()
    {
        $response = $this->delete('/api/regiao/100');

        $response->assertStatus(401);
    }

}
