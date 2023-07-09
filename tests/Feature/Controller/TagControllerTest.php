<?php

namespace Tests\Feature\Controller;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class TagControllerTest extends FactoryConfig
{
 

    public function test_create_nova_tag()
    {      
        $response = $this->withHeaders([
            'Authorization' =>  $this->token,
        ])->post('/api/tag', 
        [    
            "nome" => "Tag de teste",
            "categoria_tag_id" => 1 
        ]); 
 
        $response->assertStatus(200);
        $response->assertJsonPath("nome", 'Tag de teste');
    }
    
    public function test_atualizar_nova_tag()
    {      
        $response = $this->withHeaders([
            'Authorization' =>  $this->token,
        ])->post('/api/tag', 
        [   
            "id" => 1,
            "nome" => "Tag de teste",
            "categoria_tag_id" => 1 
        ]); 
 
        $response->assertStatus(200);
        $response->assertJsonPath("id", 1);
        $response->assertJsonPath("nome", 'Tag de teste');
    } 

    public function test_create_nova_tag_sem_nome()
    {      
        $response = $this->withHeaders([
            'Authorization' =>  $this->token,
        ])->post('/api/tag', 
        [   
            "id" => 1, 
            "categoria_tag_id" => 1 
        ]); 
 
        $response->assertStatus(400); 
    }

    public function test_create_nova_tag_sem_categoria()
    {      
        $response = $this->withHeaders([
            'Authorization' =>  $this->token,
        ])->post('/api/tag', 
        [   
            "id" => 1,
            "nome" => "Tag de teste" 
        ]); 
 
        $response->assertStatus(400); 
    }

    public function test_busca_tag_por_id()
    {      
        $response = $this->withHeaders([
            'Authorization' =>  $this->token,
        ])->get('/api/tag/1'); 
 
        $response->assertStatus(200);
        $response->assertJsonPath("nome", $this->tag->nome); 
    }

    
    public function test_busca_tag_por_id_invalido()
    {      
        $response = $this->withHeaders([
            'Authorization' =>  $this->token,
        ])->get('/api/tag/100'); 
 
        $response->assertStatus(404); 
    }

        
    public function test_delete_tag_por_id()
    {      
        $response = $this->withHeaders([
            'Authorization' =>  $this->token,
        ])->delete('/api/tag/1'); 
 
        $response->assertStatus(200); 
    }

    public function test_delete_tag_por_id_invalido()
    {      
        $response = $this->withHeaders([
            'Authorization' =>  $this->token,
        ])->delete('/api/tag/100'); 
 
        $response->assertStatus(404); 
    }

    public function test_lista_tags()
    {      
        $response = $this->withHeaders([
            'Authorization' =>  $this->token,
        ])->get('/api/tag/find/list'); 
 
        $response->assertStatus(200);  
    }
}
