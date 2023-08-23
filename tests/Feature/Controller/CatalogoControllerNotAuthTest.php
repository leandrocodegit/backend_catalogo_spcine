<?php

namespace Tests\Feature\Controller;

use App\Models\Account\PerfilUsuario;
use App\Models\Account\User;
use App\Models\Catalogo\Administrador;
use App\Models\Catalogo\Catalogo;
use App\Models\Catalogo\CategoriaCatalogo;
use App\Models\Catalogo\Cordenada;
use App\Models\Catalogo\Icon;
use App\Models\Catalogo\Regiao;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CatalogoControllerNotAuthTest extends TestCase
{
    use RefreshDatabase;


    protected $catalogo;
    protected $adminstrador;
    protected $cordenadas;
    protected $regiao;
    protected $categoriaCatalogo;
    protected $icon;
    protected $perfil;
    protected $user;

    public function setUp(): void
    {
        parent::setUp();
        $this->perfil = PerfilUsuario::factory()->create();
        $this->user = User::factory()->create();
        $this->administrador = Administrador::factory()->create();
        $this->regiao = Regiao::factory()->create();
        $this->cordenadas = Cordenada::factory()->create();
        $this->categoriaCatalogo = CategoriaCatalogo::factory()->create();
        $this->icon = Icon::factory()->create();
        $this->catalogo = Catalogo::factory()->create();
    }

    public function test_busca_catalogo_por_id()
    {

        $response = $this->get('/api/catalogo/1');

        $response->assertStatus(200);
    }

    public function test_create_novo_catalogo()
    {

        $response = $this->post('/api/catalogo',
        [
            "nome" => "Leandro",
            "endereco" => "endereco fake",
            "descricao"  => [
                "titulo" => "titulo fake",
                "descricao" => "Descricao fake"
            ]
        ]);

        $response->assertStatus(401);
    }

    public function test_create_novo_catalogo_ativado_e_home()
    {

        $response = $this->post('/api/catalogo',
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

        $response->assertStatus(401);
    }

    public function test_create_novo_catalogo_com_cordenadas()
    {

        $response = $this->post('/api/catalogo',
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

        $response->assertStatus(401);
    }

    public function test_create_novo_catalogo_sem_descricao_titulo()
    {

        $response = $this->post('/api/catalogo',
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

        $response->assertStatus(401);
    }

    public function test_create_novo_catalogo_sem_descricao_descricao()
    {

        $response = $this->post('/api/catalogo',
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

        $response->assertStatus(401);
    }

    public function test_create_novo_catalogo_sem_descricao()
    {

        $response = $this->post('/api/catalogo',
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

        $response->assertStatus(401);
    }

    public function test_create_novo_catalogo_sem_nome()
    {

        $response = $this->post('/api/catalogo',
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

        $response->assertStatus(401);
    }

    public function test_create_novo_catalogo_sem_endereco()
    {

        $response = $this->post('/api/catalogo',
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

        $response->assertStatus(401);
    }

    public function test_create_editar_catalogo_com_cordenadas()
    {

        $response = $this->patch('/api/catalogo',
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

        $response->assertStatus(401);
    }

    public function test_create_editar_catalogo_sem_cordenadas()
    {

        $response = $this->patch('/api/catalogo',
        [
            "id" => 1,
            "nome" => "Leandro",
            "endereco" => "endereco fake",
            "home" => true,
            "active" => true
        ]);

        $response->assertStatus(401);
    }

    public function test_create_editar_catalogo_com_descricoes()
    {

        $response = $this->patch('/api/catalogo',
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

        $response->assertStatus(401);
    }

    public function test_create_editar_catalogo_com_descricoes_invalido()
    {

        $response = $this->patch('/api/catalogo',
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

        $response->assertStatus(401);
    }


    public function test_create_editar_catalogo_com_tags()
    {

        $response = $this->patch('/api/catalogo',
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

        $response->assertStatus(401);
    }

    public function test_create_editar_catalogo_com_regiao()
    {

        $response = $this->patch('/api/catalogo',
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

        $response->assertStatus(401);
    }

    public function test_create_editar_catalogo_com_regras()
    {

        $response = $this->patch('/api/catalogo',
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

        $response->assertStatus(401);
    }

    public function test_create_editar_catalogo_com_precos()
    {

        $response = $this->patch('/api/catalogo',
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

        $response->assertStatus(401);
    }

    public function test_create_editar_catalogo_com_precos_sem_valor()
    {

        $response = $this->patch('/api/catalogo',
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

        $response->assertStatus(401);
    }

}
