<?php

namespace Tests\Feature\Controller;


use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use App\Models\Account\User;
use App\Models\Account\PerfilUsuario;
use App\Models\Catalogo\Catalogo;
use App\Models\Catalogo\Imagem;
use App\Models\Catalogo\Administrador;
use App\Models\Catalogo\Regiao;
use App\Models\Catalogo\Cordenada; 
use App\Models\Catalogo\CategoriaTag; 
use App\Models\Catalogo\Tag; 
use App\Models\Catalogo\Regra; 
use App\Models\Catalogo\Preco; 
use Tymon\JWTAuth\Facades\JWTAuth;

class FactoryConfig extends TestCase
{
 
    use RefreshDatabase;

    protected string $token;
    protected $perfil;
    protected $user;
    protected $catalogo;
    protected $imagem;
    protected $adminstrador;
    protected $cordenadas;
    protected $regiao;
    protected $tag;
    protected $categoria;
    protected $regra;
    protected $preco;

    public function setUp(): void
    {
        parent::setUp(); 
        $this->perfil = PerfilUsuario::factory()->create();
        $this->user = User::factory()->create();
        $this->administrador = Administrador::factory()->create();
        $this->regiao = Regiao::factory()->create();
        $this->cordenadas = Cordenada::factory()->create();
        $this->catalogo = Catalogo::factory()->create();
        $this->imagem = Imagem::factory()->create();
        $this->categoria = CategoriaTag::factory()->create();
        $this->tag = Tag::factory()->create();        
        $this->preco = Preco::factory()->create();
        $this->regra = Regra::factory()->create();        

        $this->token = 'Bearer ' .JWTAuth::fromUser($this->user); 
    }
 
}
