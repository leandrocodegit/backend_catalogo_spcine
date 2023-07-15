<?php

namespace Tests\Feature\Controller;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class TipoRegraControllerNotAuthTest extends TestCase
{
    public function test_create_tipo_regra_tag()
    {      
        $response = $this->post('/api/tipo/regra', 
        [    
            "nome" => "Tipo de regra teste"
        ]); 
 
        $response->assertStatus(401); 
    }
    
    public function test_atualizar_tipo_regra_tag()
    {      
        $response = $this->post('/api/tipo/regra', 
        [   
            "id" => 1,
            "nome" => "Tipo de regra de teste", 
        ]); 
 
        $response->assertStatus(401); 
    } 

    public function test_create_nova_tipo_regra_sem_nome()
    {      
        $response = $this->post('/api/tipo/regra', 
        [   
            "id" => 1,  
        ]); 
 
        $response->assertStatus(401); 
    }
 

    public function test_busca_tipo_regra_por_id()
    {      
        $response = $this->get('/api/tipo/regra/1'); 
 
        $response->assertStatus(401); 
    }

    
    public function test_busca_tipo_regra_por_id_invalido()
    {      
        $response = $this->get('/api/tipo/regra/100'); 
 
        $response->assertStatus(401); 
    }

        
    public function test_delete_tipo_regra_por_id()
    {      
        $response = $this->delete('/api/tipo/regra/1'); 
 
        $response->assertStatus(401); 
    }

    public function test_delete_tipo_regra_por_id_invalido()
    {      
        $response = $this->delete('/api/tipo/regra/100'); 
 
        $response->assertStatus(401); 
    }

    public function test_lista_tipos_de_regra()
    {      
        $response = $this->get('/api/tipo/regra/find/list'); 
 
        $response->assertStatus(401);  
    }
}
