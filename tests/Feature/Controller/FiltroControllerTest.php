<?php

namespace Controller;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Testing\Fluent\AssertableJson;
use Tests\Feature\Controller\FactoryConfig;
use Tests\TestCase;

class FiltroControllerTest extends FactoryConfig
{


    public function test_busca_filtros()
    {
        $response = $this->withHeaders([
            'Authorization' =>  $this->token,
        ])->get('/api/util/filtro');

        $response->assertStatus(200);
        $response->assertJson(fn (AssertableJson $json) =>
        $json->hasAll(['categoriasTag', 'categoriasCatalogo', 'regioes', 'tipos', 'administrador', 'preco']));
    }

    public function test_busca_filtros_nao_autenticado()
    {
        $response = $this->get('/api/util/filtro');

        $response->assertStatus(200);
        $response->assertJson(fn (AssertableJson $json) =>
        $json->hasAll(['categoriasTag', 'categoriasCatalogo', 'regioes', 'tipos', 'administrador', 'preco']));
    }


}
