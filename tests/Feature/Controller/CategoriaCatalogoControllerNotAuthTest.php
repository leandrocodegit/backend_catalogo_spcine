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


class CategoriaCatalogoControllerNotAuthTest extends FactoryConfig
{


    public function test_list_categorias_catalogo()
    {

        $response = $this->get('/api/catalogo/categoria/list');

        $response->assertStatus(401);
    }

    public function test_create_nova_categoria_catalogo()
    {
        $response = $this->post('/api/catalogo/categoria',
            [
                'nome' => 'Categoria test'
            ]);

        $response->assertStatus(401);
    }

    public function test_busca_categoria_catalogo_por_id()
    {
        $response = $this->get('/api/catalogo/categoria/' .$this->categoriaCatalogo->id);

        $response->assertStatus(401);
    }

    public function test_busca_categoria_catalogo_por_id_not_exits()
    {
        $response = $this->get('/api/catalogo/categoria/2');

        $response->assertStatus(401);
    }

    public function test_atualizar_categoria_catalogo()
    {
        $response = $this->patch('/api/catalogo/categoria',
            [
                'id' => $this->categoriaCatalogo->id,
                'nome' => 'response'
            ]);

        $response->assertStatus(401);

    }

    public function test_atualizar_categoria_catalogo_id_invalido()
    {
        $response = $this->patch('/api/catalogo/categoria',
            [
                'nome' => 'response'
            ]);

        $response->assertStatus(401);
    }

    public function test_delete_categoria_catalogo_id()
    {
        $response = $this->delete('/api/catalogo/categoria/' .$this->categoriaCatalogo->id);

        $response->assertStatus(401);
    }

    public function test_delete_categoria_catalogo_id_invalido()
    {
        $response = $this->delete('/api/catalogo/categoria/100');

        $response->assertStatus(401);
    }

}
