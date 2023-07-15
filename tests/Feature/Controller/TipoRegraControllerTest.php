<?php

namespace Tests\Feature\Controller;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class TipoRegraControllerTest extends FactoryConfig
{
    public function test_create_tipo_regra_tag()
    {      
        $response = $this->withHeaders([
            'Authorization' =>  $this->token,
        ])->post('/api/tipo/regra', 
        [    
            "nome" => "Tipo de regra teste"
        ]); 
 
        $response->assertStatus(200);
        $response->assertJsonPath("nome", 'Tipo de regra teste');
    }
    
    public function test_atualizar_tipo_regra_tag()
    {      
        $response = $this->withHeaders([
            'Authorization' =>  $this->token,
        ])->post('/api/tipo/regra', 
        [   
            "id" => 1,
            "nome" => "Tipo de regra de teste", 
        ]); 
 
        $response->assertStatus(200);
        $response->assertJsonPath("id", 1);
        $response->assertJsonPath("nome", 'Tipo de regra de teste');
    } 

    public function test_create_nova_tipo_regra_sem_nome()
    {      
        $response = $this->withHeaders([
            'Authorization' =>  $this->token,
        ])->post('/api/tipo/regra', 
        [   
            "id" => 1,  
        ]); 
 
        $response->assertStatus(400); 
    }
 

    public function test_busca_tipo_regra_por_id()
    {      
        $response = $this->withHeaders([
            'Authorization' =>  $this->token,
        ])->get('/api/tipo/regra/1'); 
 
        $response->assertStatus(200);
        $response->assertJsonPath("nome", $this->tipoRegra->nome); 
    }

    
    public function test_busca_tipo_regra_por_id_invalido()
    {      
        $response = $this->withHeaders([
            'Authorization' =>  $this->token,
        ])->get('/api/tipo/regra/100'); 
 
        $response->assertStatus(404); 
    }

        
    public function test_delete_tipo_regra_por_id()
    {      
        $response = $this->withHeaders([
            'Authorization' =>  $this->token,
        ])->delete('/api/tipo/regra/1'); 
 
        $response->assertStatus(404); 
    }

    public function test_delete_tipo_regra_por_id_invalido()
    {      
        $response = $this->withHeaders([
            'Authorization' =>  $this->token,
        ])->delete('/api/tipo/regra/100'); 
 
        $response->assertStatus(404); 
    }

    public function test_lista_tipos_de_regra()
    {      
        $response = $this->withHeaders([
            'Authorization' =>  $this->token,
        ])->get('/api/tipo/regra/find/list'); 
 
        $response->assertStatus(200);  
    }
}
