<?php

namespace Tests\Feature\Controller;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CaracteristicaControllerTest extends FactoryConfig
{


    public function test_create_nova_caracteristica()
    {
        $response = $this->withHeaders([
            'Authorization' =>  $this->token,
        ])->post('/api/caracteristica',
        [
            "nome" => "Caracteristica de teste",
            "categoria_id" => 1
        ]);

        $response->assertStatus(200);
    }

    public function test_atualizar_nova_caracteristica()
    {
        $response = $this->withHeaders([
            'Authorization' =>  $this->token,
        ])->post('/api/caracteristica',
        [
            "id" => 1,
            "nome" => "Caracteristica de teste",
            "categoria_id" => 1
        ]);

        $response->assertStatus(200);
    }

    public function test_create_nova_caracteristica_sem_nome()
    {
        $response = $this->withHeaders([
            'Authorization' =>  $this->token,
        ])->post('/api/caracteristica',
        [
            "id" => 1,
            "categoria_id" => 1
        ]);

        $response->assertStatus(400);
    }

    public function test_create_nova_caracteristica_sem_categoria()
    {
        $response = $this->withHeaders([
            'Authorization' =>  $this->token,
        ])->post('/api/caracteristica',
        [
            "id" => 1,
            "nome" => "Caracteristica de teste"
        ]);

        $response->assertStatus(400);
    }

    public function test_busca_caracteristica_por_id()
    {
        $response = $this->withHeaders([
            'Authorization' =>  $this->token,
        ])->get('/api/caracteristica/1');

        $response->assertStatus(200);
        $response->assertJsonPath("nome", $this->tag->nome);
    }


    public function test_busca_caracteristica_por_id_invalido()
    {
        $response = $this->withHeaders([
            'Authorization' =>  $this->token,
        ])->get('/api/caracteristica/100');

        $response->assertStatus(404);
    }


    public function test_delete_caracteristica_por_id()
    {
        $response = $this->withHeaders([
            'Authorization' =>  $this->token,
        ])->delete('/api/caracteristica/1');

        $response->assertStatus(200);
    }

    public function test_delete_caracteristica_por_id_invalido()
    {
        $response = $this->withHeaders([
            'Authorization' =>  $this->token,
        ])->delete('/api/caracteristica/100');

        $response->assertStatus(404);
    }

    public function test_lista_caracteristicas()
    {
        $response = $this->withHeaders([
            'Authorization' =>  $this->token,
        ])->get('/api/caracteristica/find/list');

        $response->assertStatus(200);
    }
}
