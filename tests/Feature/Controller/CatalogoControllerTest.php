<?php

namespace Tests\Feature\Controller;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CatalogoControllerTest extends FactoryConfig
{

    public function test_busca_catalogo_por_id()
    {
      
        $response = $this->withHeaders([
            'Authorization' =>  $this->token,
        ])->get('/api/catalogo/1'); 
 
        $response->assertStatus(200); 
        $response->assertJsonPath("id", 1); 
    }

    public function test_create_novo_catalogo()
    {
 
        $response = $this->withHeaders([
            'Authorization' =>  $this->token,
        ])->post('/api/catalogo', 
        [  
            "nome" => "Leandro",
            "endereco" => "endereco fake",
            "descricao"  => [ 
                "titulo" => "titulo fake",
                "descricao" => "Descricao fake"
            ]
        ]); 
 
        $response->assertStatus(200);
    }

    public function test_create_novo_catalogo_ativado_e_home()
    {
 
        $response = $this->withHeaders([
            'Authorization' =>  $this->token,
        ])->post('/api/catalogo', 
        [  
            "nome" => "Leandro",
            "endereco" => "endereco fake",
            "home" => true,
            "active" => true,
            "descricao"  => [ 
                "titulo" => "titulo fake",
                "descricao" => "Descricao fake"
            ]
        ]); 
 
        $response->assertStatus(200);
    }

    public function test_create_novo_catalogo_com_cordenadas()
    {
 
        $response = $this->withHeaders([
            'Authorization' =>  $this->token,
        ])->post('/api/catalogo', 
        [  
            "nome" => "Leandro",
            "endereco" => "endereco fake",
            "home" => true,
            "active" => true,
            "cordenadas"  => [ 
                "latitude" => "-23.731546855968322",
                "longitude" => "-46.60115020353316"
            ],
            "descricao"  => [ 
                "titulo" => "titulo fake",
                "descricao" => "Descricao fake"
            ]
        ]); 
 
        $response->assertStatus(200);
    }

    public function test_create_novo_catalogo_sem_descricao_titulo()
    {
 
        $response = $this->withHeaders([
            'Authorization' =>  $this->token,
        ])->post('/api/catalogo', 
        [  
            "nome" => "Leandro",
            "endereco" => "endereco fake",
            "home" => true,
            "active" => true,
            "cordenadas"  => [ 
                "latitude" => "-23.731546855968322",
                "longitude" => "-46.60115020353316"
            ],
            "descricao"  => [                  
                "descricao" => "Descricao fake"
            ]
        ]); 
 
        $response->assertStatus(400);
    }

    public function test_create_novo_catalogo_sem_descricao_descricao()
    {
 
        $response = $this->withHeaders([
            'Authorization' =>  $this->token,
        ])->post('/api/catalogo', 
        [  
            "nome" => "Leandro",
            "endereco" => "endereco fake",
            "home" => true,
            "active" => true,
            "cordenadas"  => [ 
                "latitude" => "-23.731546855968322",
                "longitude" => "-46.60115020353316"
            ],
            "descricao"  => [  
                "descricao" => "Descricao fake"
            ]
        ]); 
 
        $response->assertStatus(400);
    }

    public function test_create_novo_catalogo_sem_descricao()
    {
 
        $response = $this->withHeaders([
            'Authorization' =>  $this->token,
        ])->post('/api/catalogo', 
        [  
            "nome" => "Leandro",
            "endereco" => "endereco fake",
            "home" => true,
            "active" => true,
            "cordenadas"  => [ 
                "latitude" => "-23.731546855968322",
                "longitude" => "-46.60115020353316"
            ]
        ]); 
 
        $response->assertStatus(400);
    }

    public function test_create_novo_catalogo_sem_nome()
    {
 
        $response = $this->withHeaders([
            'Authorization' =>  $this->token,
        ])->post('/api/catalogo', 
        [              
            "endereco" => "endereco fake",
            "home" => true,
            "active" => true,
            "cordenadas"  => [ 
                "latitude" => "-23.731546855968322",
                "longitude" => "-46.60115020353316"
            ],
            "descricao"  => [ 
                "titulo" => "titulo fake",
                "descricao" => "Descricao fake"
            ]
        ]); 
 
        $response->assertStatus(400);
    }

    public function test_create_novo_catalogo_sem_endereco()
    {
 
        $response = $this->withHeaders([
            'Authorization' =>  $this->token,
        ])->post('/api/catalogo', 
        [  
            "nome" => "Leandro", 
            "home" => true,
            "active" => true,
            "cordenadas"  => [ 
                "latitude" => "-23.731546855968322",
                "longitude" => "-46.60115020353316"
            ],
            "descricao"  => [ 
                "titulo" => "titulo fake",
                "descricao" => "Descricao fake"
            ]
        ]); 
 
        $response->assertStatus(400);
    }

    public function test_create_editar_catalogo_com_cordenadas()
    {
 
        $response = $this->withHeaders([
            'Authorization' =>  $this->token,
        ])->patch('/api/catalogo', 
        [  
            "id" => 1,
            "nome" => "Leandro",
            "endereco" => "endereco fake",
            "home" => true,
            "active" => true,
            "cordenadas"  => [ 
                "id" => 1,
                "latitude" => "-23.731546855968322",
                "longitude" => "-46.60115020353316"
            ] 
        ]); 
 
        $response->assertStatus(200);
    }

    public function test_create_editar_catalogo_sem_cordenadas()
    {
 
        $response = $this->withHeaders([
            'Authorization' =>  $this->token,
        ])->patch('/api/catalogo', 
        [  
            "id" => 1,
            "nome" => "Leandro",
            "endereco" => "endereco fake",
            "home" => true,
            "active" => true
        ]); 
 
        $response->assertStatus(200);
    }

    public function test_create_editar_catalogo_com_descricoes()
    {
 
        $response = $this->withHeaders([
            'Authorization' =>  $this->token,
        ])->patch('/api/catalogo', 
        [  
            "id" => 1,
            "nome" => "Leandro",
            "endereco" => "endereco fake",
            "home" => true,
            "active" => true,
            "descricoes"  => [
                [  
                "titulo" => "titulo fake",
                "descricao" => "descricao fake"
            ]] 
        ]); 

        $this->assertTrue(count($response['descricoes']) === 1);
        $response->assertJsonPath("id", 1); 
        $response->assertStatus(200);
    }

    public function test_create_editar_catalogo_com_descricoes_invalido()
    {
 
        $response = $this->withHeaders([
            'Authorization' =>  $this->token,
        ])->patch('/api/catalogo', 
        [  
            "id" => 1,
            "nome" => "Leandro",
            "endereco" => "endereco fake",
            "home" => true,
            "active" => true,
            "descricoes"  => [
                [   
            ]] 
        ]); 

        $this->assertTrue(count($response['descricoes']) === 0);
        $response->assertJsonPath("id", 1); 
        $response->assertStatus(200);
    }

    
    public function test_create_editar_catalogo_com_tags()
    {
 
        $response = $this->withHeaders([
            'Authorization' =>  $this->token,
        ])->patch('/api/catalogo', 
        [  
            "id" => 1,
            "nome" => "Leandro",
            "endereco" => "endereco fake",
            "home" => true,
            "active" => true,
            "tags"  => [
                [  
                    "id" => 1 
                ]
                ] 
        ]); 

        $this->assertTrue(count($response['tags']) === 1);
        $response->assertJsonPath("id", 1); 
        $response->assertStatus(200);
    }

    public function test_create_editar_catalogo_com_regiao()
    {
 
        $response = $this->withHeaders([
            'Authorization' =>  $this->token,
        ])->patch('/api/catalogo', 
        [  
            "id" => 1,
            "nome" => "Leandro",
            "endereco" => "endereco fake",
            "home" => true,
            "active" => true,
            "regiao"  => [ 
                    "id" => 1  
                ] 
        ]); 
 
        $response->assertJsonPath("id", 1);
        $response->assertJsonPath("regiao.id", 1); 
        $response->assertStatus(200);
    }

    public function test_create_editar_catalogo_com_regras()
    {
 
        $response = $this->withHeaders([
            'Authorization' =>  $this->token,
        ])->patch('/api/catalogo', 
        [  
            "id" => 1,
            "nome" => "Leandro",
            "endereco" => "endereco fake",
            "home" => true,
            "active" => true,
            "regras"  => [
                [  
                    "id" => 1 
                ]
                ] 
        ]); 

        $this->assertTrue(count($response['regras']) === 1);
        $response->assertJsonPath("id", 1); 
        $response->assertStatus(200);
    }

    public function test_create_editar_catalogo_com_precos()
    {
 
        $response = $this->withHeaders([
            'Authorization' =>  $this->token,
        ])->patch('/api/catalogo', 
        [  
            "id" => 1,
            "nome" => "Leandro",
            "endereco" => "endereco fake",
            "home" => true,
            "active" => true,
            "precos"  => [
                [  
                    "id" => 1,
                    "valor" => 200,
                    "descricao" => 'descricao'
                ]
                ] 
        ]); 

        $this->assertTrue(count($response['precos']) === 1);
        $response->assertJsonPath("id", 1); 
        $response->assertStatus(200);
    }

    public function test_create_editar_catalogo_com_precos_sem_valor()
    {
 
        $response = $this->withHeaders([
            'Authorization' =>  $this->token,
        ])->patch('/api/catalogo', 
        [  
            "id" => 1,
            "nome" => "Leandro",
            "endereco" => "endereco fake",
            "home" => true,
            "active" => true,
            "precos"  => [
                [  
                    "id" => 1 
                ]
                ] 
        ]); 

        $this->assertTrue(count($response['precos']) === 1);
        $response->assertJsonPath("id", 1); 
        $response->assertStatus(200);
    }

}
