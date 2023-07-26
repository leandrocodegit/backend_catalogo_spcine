<?php

namespace Controller;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Mockery\MockInterface;
use App\Models\catalogo\CategoriaCaracteristica;
use App\Models\Account\PerfilUsuario;
use App\Models\Account\User;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Testing\Fluent\AssertableJson;


class CategoriaCaracteristicaControllerNotAuthTest extends TestCase
{

    use RefreshDatabase;

    protected $token;
    protected $categoria;
    protected $perfil;
    protected $user;

    public function setUp(): void
    {
        parent::setUp();
        $this->perfil = PerfilUsuario::factory()->create();
        $this->user = User::factory()->create();
        $this->categoria = CategoriaCaracteristica::factory()->create();

        $this->token = 'Bearer ' .JWTAuth::fromUser($this->user);
    }

    public function test_list_categorias()
    {

        $response = $this->get('/api/caracteristica/categoria/list');

        $response->assertStatus(401);
    }

    public function test_create_nova_categoria()
    {
        $response = $this->post('/api/caracteristica/categoria',
            [
                'nome' => 'Categoria test'
            ]);

        $response->assertStatus(401);
    }

    public function test_busca_categoria_por_id()
    {
        $response = $this->get('/api/caracteristica/categoria/' .$this->categoria->id);

        $response->assertStatus(401);
    }

    public function test_busca_categoria_por_id_not_exits()
    {
        $response = $this->get('/api/caracteristica/categoria/2');

        $response->assertStatus(401);
    }

    public function test_atualizar_categoria()
    {
        $response = $this->patch('/api/caracteristica/categoria',
            [
                'id' => $this->categoria->id,
                'nome' => 'response'
            ]);

        $response->assertStatus(401);

    }

    public function test_atualizar_categoria_caracteristica_id_invalido()
    {
        $response = $this->patch('/api/caracteristica/categoria',
            [
                'nome' => 'response'
            ]);

        $response->assertStatus(401);
    }

    public function test_delete_categoria_caracteristica_id_vinculado()
    {
        $response = $this->delete('/api/caracteristica/categoria/' .$this->categoria->id);

        $response->assertStatus(401);
    }

    public function test_delete_categoria_caracteristica_id_invalido()
    {
        $response = $this->delete('/api/caracteristica/categoria/100');

        $response->assertStatus(401);
    }

}
