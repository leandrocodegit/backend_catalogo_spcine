<?php

namespace Tests\Feature\Controller;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Mockery\MockInterface; 
use App\Models\catalogo\CategoriaTag; 
use App\Models\Account\PerfilUsuario;
use App\Models\Account\User;  
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Testing\Fluent\AssertableJson;


class CategoriaTagControllerTest extends TestCase
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
        $this->categoria = CategoriaTag::factory()->create(); 
       
        $this->token = 'Bearer ' .JWTAuth::fromUser($this->user);  
    }
 
    public function test_list_categorias()
    {
 
        $response = $this->withHeaders([
            'Authorization' =>  $this->token,
        ])->get('/api/categoria'); 
 
        $response->assertStatus(200);
        $this->assertTrue(count($response->decodeResponseJson()) > 0);
    }

    public function test_create_nova_categoria()
    { 
        $response = $this->withHeaders([
            'Authorization' =>  $this->token,
        ])->post('/api/categoria',
            [
                'nome' => 'Categoria test'                
            ]); 
 
        $response->assertStatus(200);
    }

    public function test_busca_categoria_por_id()
    { 
        $response = $this->withHeaders([
            'Authorization' =>  $this->token,
        ])->get('/api/categoria/' .$this->categoria->id); 
 
        $response->assertStatus(200);
    }

    public function test_busca_categoria_por_id_not_exits()
    { 
        $response = $this->withHeaders([
            'Authorization' =>  $this->token,
        ])->get('/api/categoria/2'); 
 
        $response->assertStatus(202);
    }

    public function test_atualizar_categoria()
    { 
        $response = $this->withHeaders([
            'Authorization' =>  $this->token,
        ])->patch('/api/categoria',
            [
                'id' => $this->categoria->id,
                'nome' => 'response'                
            ]); 
 
        $response->assertStatus(200);

        $response = $this->withHeaders([
            'Authorization' =>  $this->token,
        ])->get('/api/categoria/' .$this->categoria->id); 
 
        $response->assertStatus(200);
        $response->assertJsonPath("nome", "response"); 
    }
     
}
