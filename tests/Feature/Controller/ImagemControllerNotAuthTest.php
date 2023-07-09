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

class ImagemControllerNotAuthTest extends TestCase
{
 
    use RefreshDatabase;

    private string $token;
    protected $perfil;
    protected $user;
    protected $catalogo;
    protected $imagem;
    protected $adminstrador;
    protected $cordenadas;
    protected $regiao;

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
 
    }
    
    public function test_upload_nova_imagem()
    {
     
        Storage::fake('imagens/1'); 
        $response = $this->post('/api/imagem', 
        [  
            "file" => UploadedFile::fake()->image('teste.jpg'),
            "titulo" => "Titulo teste",
            "descricao" => "Descrição de teste",
            "catalogo_id" => $this->catalogo->id 
        ]); 
 
        $response->assertStatus(401);
    }

    public function test_upload_alterar_imagem()
    {
     
        Storage::fake('imagens/1'); 
        $response = $this->post('/api/imagem/file', 
        [  
            "file" => UploadedFile::fake()->image('teste.jpg'),
            "id" => $this->imagem->id 
        ]); 
 
        $response->assertStatus(401);
    }

    public function test_upload_alterar_imagem_nao_cadastrada()
    {
      
        $response = $this->post('/api/imagem/file', 
        [  
            "file" => null,
            "id" => 20 
        ]); 
 
        $response->assertStatus(401);
    }

    public function test_upload_nova_imagem_catalogo_nao_cadastrado()
    {
     
        Storage::fake('imagens/1'); 
        $response = $this->post('/api/imagem', 
        [  
            "file" => UploadedFile::fake()->image('teste.jpg'),
            "titulo" => "Titulo teste",
            "descricao" => "Descrição de teste",
            "catalogo_id" => 20 
        ]); 
 
        $response->assertStatus(401);
    }

    public function test_upload_nova_imagem_catalogo_sem_catalogo()
        {
         
            Storage::fake('imagens/1'); 
            $response = $this->post('/api/imagem', 
            [  
                "file" => UploadedFile::fake()->image('teste.jpg'),
                "titulo" => "Titulo teste",
                "descricao" => "Descrição de teste", 
            ]); 
     
            $response->assertStatus(401);       
    }

    public function test_delete_imagem()
    {      
        Storage::fake('imagens/1');
        UploadedFile::fake()->image('teste.jpg');
        $response = $this->delete('/api/imagem/' .$this->imagem->id);  
        $response->assertStatus(401);
    }

    public function test_delete_imagem_que_nao_cadastrado()
    {
      
        $response = $this->delete('/api/imagem/2');  
        $response->assertStatus(401);
    }

    public function test_edit_imagem()
    {
      
        $response = $this->patch('/api/imagem', 
        [  
            "id" => $this->imagem->id,
            "titulo" => "Titulo teste",
            "descricao" => "Descrição de teste",
            "ordem" => 2,
            "principal" => false,
            "catalogo_id" => $this->catalogo->id 
        ]); 

        $response->assertStatus(401); 
    }

    public function test_busca_imagem_por_id()
    {
      
        $response = $this->get('/api/imagem/' .$this->imagem->id); 
 
        $response->assertStatus(401);
  
    }

    public function test_busca_imagem_por_id_nao_cadastrado()
    {
      
        $response = $this->get('/api/imagem/20'); 
 
        $response->assertStatus(401); 
    }
}
