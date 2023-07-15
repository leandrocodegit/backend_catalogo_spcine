<?php

namespace Tests\Feature\Controller;


use App\Models\Account\PerfilUsuario;
use App\Models\Account\User;
use App\Models\Catalogo\Administrador;
use App\Models\Catalogo\Catalogo;
use App\Models\Catalogo\CategoriaTag;
use App\Models\Catalogo\Cordenada;
use App\Models\Catalogo\Icon;
use App\Models\Catalogo\Imagem;
use App\Models\Catalogo\Preco;
use App\Models\Catalogo\Regiao;
use App\Models\Catalogo\Regra;
use App\Models\Catalogo\Tag;
use App\Models\Catalogo\TipoRegra;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Tymon\JWTAuth\Facades\JWTAuth;

class FactoryConfig extends FactoryAuthConfig
{

    protected $catalogo;
    protected $imagem;
    protected $adminstrador;
    protected $cordenadas;
    protected $regiao;
    protected $tag;
    protected $categoria;
    protected $tipoRegra;
    protected $regra;
    protected $preco;
    protected $icon;

    public function setUp(): void
    {
        parent::setUp();
        $this->administrador = Administrador::factory()->create();
        $this->regiao = Regiao::factory()->create();
        $this->cordenadas = Cordenada::factory()->create();
        $this->catalogo = Catalogo::factory()->create();
        $this->imagem = Imagem::factory()->create();
        $this->categoria = CategoriaTag::factory()->create();
        $this->tag = Tag::factory()->create();
        $this->preco = Preco::factory()->create();
        $this->tipoRegra = TipoRegra::factory()->create();
        $this->regra = Regra::factory()->create();
        $this->icon = Icon::factory()->create();
    }

}
