<?php

namespace Tests\Feature\Controller;


use App\Models\Account\PerfilUsuario;
use App\Models\Account\User;
use App\Models\Catalogo\Administrador;
use App\Models\Catalogo\Catalogo;
use App\Models\Catalogo\CategoriaCatalogo;
use App\Models\Catalogo\CategoriaCaracteristica;
use App\Models\Catalogo\Cordenada;
use App\Models\Catalogo\Icon;
use App\Models\Catalogo\Imagem;
use App\Models\Catalogo\Preco;
use App\Models\Catalogo\Regiao;
use App\Models\Catalogo\Regra;
use App\Models\Catalogo\Caracteristica;
use App\Models\Catalogo\RegrasCatalogo;
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
    protected $categoriaCatalogo;
    protected $regrasCatalogo;

    public function setUp(): void
    {
        parent::setUp();
        $this->administrador = Administrador::factory()->create();
        $this->regiao = Regiao::factory()->create();
        $this->cordenadas = Cordenada::factory()->create();
        $this->categoriaCatalogo = CategoriaCatalogo::factory()->create();
        $this->icon = Icon::factory()->create();
        $this->catalogo = Catalogo::factory()->create();
        $this->categoria = CategoriaCaracteristica::factory()->create();
        $this->tag = Caracteristica::factory()->create();
        $this->preco = Preco::factory()->create();
        $this->tipoRegra = TipoRegra::factory()->create();
        $this->regra = Regra::factory()->create();
        $this->imagem = Imagem::factory()->create();
        $this->regrasCatalogo = RegrasCatalogo::factory();


    }

}
