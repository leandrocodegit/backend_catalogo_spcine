<?php

namespace Controller;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Testing\Fluent\AssertableJson;
use Tests\Feature\Controller\FactoryConfig;
use Tests\TestCase;

class CatalogoControllerFiltrosTest extends FactoryConfig
{


    public function test_busca_catalogo_com_filtros_all()
    {
        $response = $this->withHeaders([
            'Authorization' =>  $this->token,
        ])->post('/api/catalogo/filter/list', [
            "isAll" => true,
            "nome" =>  "",
            "caracteristicas" => [],
            "categorias" =>  [],
            "regras" =>  [],
            "administrador" =>  [],
            "preco" =>  0
        ]);

        $response->assertStatus(200);
        $response->assertJsonPath("to", 1);
    }


    public function test_busca_catalogo_com_filtros_categoria()
    {
        $response = $this->withHeaders([
            'Authorization' =>  $this->token,
        ])->post('/api/catalogo/filter/list', [
            "isAll" => false,
            "nome" =>  "",
            "caracteristicas" => [],
            "categorias" =>  [1],
            "regras" =>  [],
            "administrador" =>  [],
            "preco" =>  0
        ]);

        $response->assertStatus(200);
        $response->assertJsonPath("to", 1);
    }

}
