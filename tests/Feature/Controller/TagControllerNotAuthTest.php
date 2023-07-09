<?php

namespace Tests\Feature\Controller;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class TagControllerNotAuthTest extends FactoryConfig
{
 

    public function test_create_nova_tag()
    {      
        $response = $this->post('/api/tag', 
        [   
            "id" => 1,
            "nome" => "Tag de teste",
            "categoria_tag_id" => 1 
        ]); 
 
        $response->assertStatus(401); 
    }

    public function test_create_nova_tag_sem_nome()
    {      
        $response = $this->post('/api/tag', 
        [   
            "id" => 1, 
            "categoria_tag_id" => 1 
        ]); 
 
        $response->assertStatus(401); 
    }

    public function test_create_nova_tag_sem_categoria()
    {      
        $response = $this->post('/api/tag', 
        [   
            "id" => 1,
            "nome" => "Tag de teste" 
        ]); 
 
        $response->assertStatus(401); 
    }

    public function test_busca_tag_por_id()
    {      
        $response = $this->get('/api/tag/1'); 
 
        $response->assertStatus(401); 
    }

    
    public function test_busca_tag_por_id_invalido()
    {      
        $response = $this->get('/api/tag/100'); 
 
        $response->assertStatus(401); 
    }

        
    public function test_delete_tag_por_id()
    {      
        $response = $this->delete('/api/tag/1'); 
 
        $response->assertStatus(401); 
    }

    public function test_delete_tag_por_id_invalido()
    {      
        $response = $this->delete('/api/tag/100'); 
 
        $response->assertStatus(401); 
    }

    public function test_lista_tags()
    {      
        $response = $this->get('/api/tag/find/list'); 
 
        $response->assertStatus(401);  
    }
}
