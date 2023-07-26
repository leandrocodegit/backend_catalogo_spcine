<?php

namespace Tests\Feature\Controller;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CaracteristicaControllerNotAuthTest extends FactoryConfig
{


    public function test_create_nova_caracteristica()
    {
        $response = $this->post('/api/caracteristica',
        [
            "id" => 1,
            "nome" => "Caracteristica de teste",
            "categoria_caracteristica_id" => 1
        ]);

        $response->assertStatus(401);
    }

    public function test_create_nova_caracteristica_sem_nome()
    {
        $response = $this->post('/api/caracteristica',
        [
            "id" => 1,
            "categoria_caracteristica_id" => 1
        ]);

        $response->assertStatus(401);
    }

    public function test_create_nova_caracteristica_sem_categoria()
    {
        $response = $this->post('/api/caracteristica',
        [
            "id" => 1,
            "nome" => "Caracteristica de teste"
        ]);

        $response->assertStatus(401);
    }

    public function test_busca_caracteristica_por_id()
    {
        $response = $this->get('/api/caracteristica/1');

        $response->assertStatus(401);
    }


    public function test_busca_caracteristica_por_id_invalido()
    {
        $response = $this->get('/api/caracteristica/100');

        $response->assertStatus(401);
    }


    public function test_delete_caracteristica_por_id()
    {
        $response = $this->delete('/api/caracteristica/1');

        $response->assertStatus(401);
    }

    public function test_delete_caracteristica_por_id_invalido()
    {
        $response = $this->delete('/api/caracteristica/100');

        $response->assertStatus(401);
    }

    public function test_lista_caracteristicas()
    {
        $response = $this->get('/api/caracteristica/find/list');

        $response->assertStatus(401);
    }
}
