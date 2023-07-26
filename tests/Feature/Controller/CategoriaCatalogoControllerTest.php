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


class CategoriaCatalogoControllerTest extends FactoryConfig
{


    public function test_list_categorias_catalogo()
    {

        $response = $this->withHeaders([
            'Authorization' =>  $this->token,
        ])->get('/api/catalogo/categoria/list');

        $response->assertStatus(200);
        $this->assertTrue(count($response->decodeResponseJson()) > 0);
    }

    public function test_create_nova_categoria_catalogo()
    {
        $response = $this->withHeaders([
            'Authorization' =>  $this->token,
        ])->post('/api/catalogo/categoria',
            [
                'nome' => 'Categoria test'
            ]);

        $response->assertStatus(200);
    }

    public function test_busca_categoria_catalogo_por_id()
    {
        $response = $this->withHeaders([
            'Authorization' =>  $this->token,
        ])->get('/api/catalogo/categoria/' .$this->categoriaCatalogo->id);

        $response->assertStatus(200);
    }

    public function test_busca_categoria_catalogo_por_id_not_exits()
    {
        $response = $this->withHeaders([
            'Authorization' =>  $this->token,
        ])->get('/api/catalogo/categoria/2');

        $response->assertStatus(404);
    }

    public function test_atualizar_categoria_catalogo()
    {
        $response = $this->withHeaders([
            'Authorization' =>  $this->token,
        ])->patch('/api/catalogo/categoria',
            [
                'id' => $this->categoriaCatalogo->id,
                'nome' => 'response'
            ]);

        $response->assertStatus(200);

        $response = $this->withHeaders([
            'Authorization' =>  $this->token,
        ])->get('/api/catalogo/categoria/' .$this->categoriaCatalogo->id);

        $response->assertStatus(200);
        $response->assertJsonPath("nome", "response");
    }

    public function test_atualizar_categoria_catalogo_id_invalido()
    {
        $response = $this->withHeaders([
            'Authorization' =>  $this->token,
        ])->patch('/api/catalogo/categoria',
            [
                'nome' => 'response'
            ]);

        $response->assertStatus(400);
    }

    public function test_delete_categoria_catalogo_id_vinculado()
    {
        $response = $this->withHeaders([
            'Authorization' =>  $this->token,
        ])->delete('/api/catalogo/categoria/' .$this->categoriaCatalogo->id);

        $response->assertStatus(404);
    }

    public function test_delete_categoria_catalogo_id_invalido()
    {
        $response = $this->withHeaders([
            'Authorization' =>  $this->token,
        ])->delete('/api/catalogo/categoria/100');

        $response->assertStatus(404);
    }

}
