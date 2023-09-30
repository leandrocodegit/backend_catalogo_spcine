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
            'Authorization' => $this->token,
        ])->get('/api/catalogo/1');

        $response->assertStatus(200);
    }

    public function test_create_novo_catalogo()
    {

        $response = $this->withHeaders([
            'Authorization' => $this->token,
        ])->post('/api/catalogo',
            [
                "nome" => "Leandro",
                "like" => "Praça da sé",
                "like_langue" => "Praça da sé",
                "hora_inicial" => "2023-09-04 12:01:24",
                "hora_final" => "2023-09-04 12:01:24",
                "endereco" => "endereco fake",
                "descricao" => [
                    "titulo" => "titulo fake",
                    "descricao" => "Descricao fake"
                ]
            ]);

        $response->assertStatus(200);
    }

    public function test_create_novo_catalogo_ativado_e_home()
    {

        $response = $this->withHeaders([
            'Authorization' => $this->token,
        ])->post('/api/catalogo',
            [
                "nome" => "Leandro",
                "endereco" => "endereco fake",
                "like" => "Praça da sé",
                "like_langue" => "Praça da sé",
                "home" => true,
                "active" => true,
                "hora_inicial" => "2023-09-04 12:01:24",
                "hora_final" => "2023-09-04 12:01:24",
                "descricao" => [
                    "titulo" => "titulo fake",
                    "descricao" => "Descricao fake"
                ]
            ]);

        $response->assertStatus(200);
    }

    public function test_create_novo_catalogo_com_cordenadas()
    {

        $response = $this->withHeaders([
            'Authorization' => $this->token,
        ])->post('/api/catalogo',
            [
                "nome" => "Leandro",
                "endereco" => "endereco fake",
                "like" => "Praça da sé",
                "like_langue" => "Praça da sé",
                "home" => true,
                "active" => true,
                "hora_inicial" => "2023-09-04 12:01:24",
                "hora_final" => "2023-09-04 12:01:24",
                "cordenadas" => [
                    "latitude" => "-23.731546855968322",
                    "longitude" => "-46.60115020353316"
                ],
                "descricao" => [
                    "titulo" => "titulo fake",
                    "descricao" => "Descricao fake"
                ]
            ]);

        $response->assertStatus(200);
    }

    public function test_create_novo_catalogo_sem_descricao_titulo()
    {

        $response = $this->withHeaders([
            'Authorization' => $this->token,
        ])->post('/api/catalogo',
            [
                "nome" => "Leandro",
                "endereco" => "endereco fake",
                "like" => "Praça da sé",
                "like_langue" => "Praça da sé",
                "home" => true,
                "active" => true,

            ]);

        $response->assertStatus(400);
    }

    public function test_create_novo_catalogo_sem_descricao_descricao()
    {

        $response = $this->withHeaders([
            'Authorization' => $this->token,
        ])->post('/api/catalogo',
            [
                "nome" => "Leandro",
                "endereco" => "endereco fake",
                "like" => "Praça da sé",
                "like_langue" => "Praça da sé",
                "home" => true,
                "active" => true,
                "hora_inicial" => "2023-09-04 12:01:24",
                "hora_final" => "2023-09-04 12:01:24",

            ]);

        $response->assertStatus(400);
    }

    public function test_create_novo_catalogo_sem_descricao()
    {

        $response = $this->withHeaders([
            'Authorization' => $this->token,
        ])->post('/api/catalogo',
            [
                "nome" => "Leandro",
                "endereco" => "endereco fake",
                "like" => "Praça da sé",
                "like_langue" => "Praça da sé",
                "home" => true,
                "active" => true,
                "hora_inicial" => "2023-09-04 12:01:24",
                "hora_final" => "2023-09-04 12:01:24",
                "cordenadas" => [
                    "latitude" => "-23.731546855968322",
                    "longitude" => "-46.60115020353316"
                ]
            ]);

        $response->assertStatus(400);
    }

    public function test_create_novo_catalogo_sem_nome()
    {

        $response = $this->withHeaders([
            'Authorization' => $this->token,
        ])->post('/api/catalogo',
            [
                "endereco" => "endereco fake",
                "home" => true,
                "like" => "Praça da sé",
                "like_langue" => "Praça da sé",
                "active" => true,
                "hora_inicial" => "2023-09-04 12:01:24",
                "hora_final" => "2023-09-04 12:01:24",
                "cordenadas" => [
                    "latitude" => "-23.731546855968322",
                    "longitude" => "-46.60115020353316"
                ],
                "descricao" => [
                    "titulo" => "titulo fake",
                    "descricao" => "Descricao fake"
                ]
            ]);

        $response->assertStatus(400);
    }

    public function test_create_novo_catalogo_sem_endereco()
    {

        $response = $this->withHeaders([
            'Authorization' => $this->token,
        ])->post('/api/catalogo',
            [
                "nome" => "Leandro",
                "home" => true,
                "like" => "Praça da sé",
                "like_langue" => "Praça da sé",
                "active" => true,
                "hora_inicial" => "2023-09-04 12:01:24",
                "hora_final" => "2023-09-04 12:01:24",
                "cordenadas" => [
                    "latitude" => "-23.731546855968322",
                    "longitude" => "-46.60115020353316"
                ],
                "descricao" => [
                    "titulo" => "titulo fake",
                    "descricao" => "Descricao fake"
                ]
            ]);

        $response->assertStatus(400);
    }

    public function test_create_editar_catalogo_com_cordenadas()
    {

        $response = $this->withHeaders([
            'Authorization' => $this->token,
        ])->patch('/api/catalogo',
            [
                "id" => 1,
                "nome" => "Leandro",
                "like" => "Praça da sé",
                "like_langue" => "Praça da sé",
                "endereco" => "endereco fake",
                "home" => true,
                "active" => true,
                "hora_inicial" => "2023-09-04 12:01:24",
                "hora_final" => "2023-09-04 12:01:24",
                "cordenadas" => [
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
            'Authorization' => $this->token,
        ])->patch('/api/catalogo',
            [
                "id" => 1,
                "nome" => "Leandro",
                "like" => "Praça da sé",
                "like_langue" => "Praça da sé",
                "endereco" => "endereco fake",
                "home" => true,
                "active" => true,
                "hora_inicial" => "2023-09-04 12:01:24",
                "hora_final" => "2023-09-04 12:01:24",
            ]);

        $response->assertStatus(200);
    }

    public function test_create_editar_catalogo_com_descricoes()
    {

        $response = $this->withHeaders([
            'Authorization' => $this->token,
        ])->patch('/api/catalogo',
            [
                "id" => 1,
                "nome" => "Leandro",
                "like" => "Praça da sé",
                "like_langue" => "Praça da sé",
                "endereco" => "endereco fake",
                "home" => true,
                "active" => true,
                "hora_inicial" => "2023-09-04 12:01:24",
                "hora_final" => "2023-09-04 12:01:24",
                "descricoes" => [
                    [
                        "titulo" => "titulo fake",
                        "descricao" => "descricao fake"
                    ]]
            ]);

        $response->assertStatus(200);
    }

    public function test_create_editar_catalogo_com_descricoes_invalido()
    {

        $response = $this->withHeaders([
            'Authorization' => $this->token,
        ])->patch('/api/catalogo',
            [
                "id" => 1,
                "nome" => "Leandro",
                "like" => "Praça da sé",
                "like_langue" => "Praça da sé",
                "endereco" => "endereco fake",
                "home" => true,
                "active" => true,
                "hora_inicial" => "2023-09-04 12:01:24",
                "hora_final" => "2023-09-04 12:01:24",
                "descricoes" => [
                    [
                    ]]
            ]);

        $response->assertStatus(200);
    }


    public function test_create_editar_catalogo_com_caracteristicas()
    {

        $response = $this->withHeaders([
            'Authorization' => $this->token,
        ])->patch('/api/catalogo',
            [
                "id" => 1,
                "nome" => "Leandro",
                "like" => "Praça da sé",
                "like_langue" => "Praça da sé",
                "endereco" => "endereco fake",
                "home" => true,
                "active" => true,
                "hora_inicial" => "2023-09-04 12:01:24",
                "hora_final" => "2023-09-04 12:01:24",
                "caracteristicas" => [
                    [
                        "id" => 1
                    ]
                ]
            ]);

        $response->assertStatus(200);
    }

    public function test_create_editar_catalogo_com_regiao()
    {

        $response = $this->withHeaders([
            'Authorization' => $this->token,
        ])->patch('/api/catalogo',
            [
                "id" => 1,
                "nome" => "Leandro",
                "like" => "Praça da sé",
                "like_langue" => "Praça da sé",
                "endereco" => "endereco fake",
                "home" => true,
                "active" => true,
                "hora_inicial" => "2023-09-04 12:01:24",
                "hora_final" => "2023-09-04 12:01:24",
                "regiao" => [
                    "id" => 1
                ]
            ]);

        $response->assertStatus(200);
    }

    public function test_create_editar_catalogo_com_regras()
    {

        $response = $this->withHeaders([
            'Authorization' => $this->token,
        ])->patch('/api/catalogo',
            [
                "id" => 1,
                "nome" => "Leandro",
                "like" => "Praça da sé",
                "like_langue" => "Praça da sé",
                "endereco" => "endereco fake",
                "home" => true,
                "active" => true,
                "hora_inicial" => "2023-09-04 12:01:24",
                "hora_final" => "2023-09-04 12:01:24",
                "regras" => [
                    [
                        "id" => 1
                    ]
                ]
            ]);

        $response->assertStatus(200);
    }

    public function test_create_editar_catalogo_com_precos()
    {

        $response = $this->withHeaders([
            'Authorization' => $this->token,
        ])->patch('/api/catalogo',
            [
                "id" => 1,
                "nome" => "Leandro",
                "like" => "Praça da sé",
                "like_langue" => "Praça da sé",
                "endereco" => "endereco fake",
                "home" => true,
                "active" => true,
                "hora_inicial" => "2023-09-04 12:01:24",
                "hora_final" => "2023-09-04 12:01:24",
                "precos" => [
                    [
                        "id" => 1,
                        "valor" => 200,
                        "descricao" => 'descricao'
                    ]
                ]
            ]);

        $response->assertStatus(200);
    }

    public function test_create_editar_catalogo_com_precos_sem_valor()
    {

        $response = $this->withHeaders([
            'Authorization' => $this->token,
        ])->patch('/api/catalogo',
            [
                "id" => 1,
                "nome" => "Leandro",
                "like" => "Praça da sé",
                "like_langue" => "Praça da sé",
                "endereco" => "endereco fake",
                "home" => true,
                "active" => true,
                "hora_inicial" => "2023-09-04 12:01:24",
                "hora_final" => "2023-09-04 12:01:24",
                "precos" => [
                    [
                        "id" => 1
                    ]
                ]
            ]);

        $response->assertStatus(200);
    }

    public function test_busca_lista_catalogo()
    {

        $response = $this->withHeaders([
            'Authorization' => $this->token,
        ])->post('/api/catalogo/filter/list',
            [
                "isAll" => false,
                "nome" => 'fake',
                "horario" => [
                    "inicial" => "00:00",
                    "final" => "23:59"
                ]
            ]);
        $response->assertStatus(200);
    }


}
