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
use Tymon\JWTAuth\Facades\JWTAuth;

class ImagemControllerTest extends FactoryConfig
{

    public function test_upload_nova_imagem()
    {

        Storage::fake('imagens/1');
        $response = $this->withHeaders([
            'Authorization' =>  $this->token,
        ])->post('/api/imagem',
        [
            "file" => UploadedFile::fake()->image('teste.jpg'),
            "titulo" => "Titulo teste",
            "descricao" => "Descrição de teste",
            "catalogo_id" => 1
        ]);

        $response->assertStatus(200);
    }

    public function test_upload_alterar_imagem()
    {

        Storage::fake('imagens/1');
        $response = $this->withHeaders([
            'Authorization' =>  $this->token,
        ])->post('/api/imagem',
        [
            "file" => UploadedFile::fake()->image('teste.jpg'),
            "id" => $this->imagem->id,
            "catalogo_id" => 1
        ]);

        $response->assertStatus(200);
    }

    public function test_upload_alterar_imagem_sem_file()
    {

        Storage::fake('imagens/1');
        $response = $this->withHeaders([
            'Authorization' =>  $this->token,
        ])->post('/api/imagem',
            [
                "id" => $this->imagem->id,
                "catalogo_id" => 1
            ]);

        $response->assertStatus(200);
    }

    public function test_upload_alterar_imagem_nao_cadastrada()
    {

        $response = $this->withHeaders([
            'Authorization' =>  $this->token,
        ])->post('/api/imagem',
        [
            "id" => 20,
            "catalogo_id" => 1
        ]);

        $response->assertStatus(200);
    }

    public function test_upload_nova_imagem_catalogo_nao_cadastrado()
    {

        Storage::fake('imagens/1');
        $response = $this->withHeaders([
            'Authorization' =>  $this->token,
        ])->post('/api/imagem',
        [
            "file" => UploadedFile::fake()->image('teste.jpg'),
            "titulo" => "Titulo teste",
            "descricao" => "Descrição de teste",
            "catalogo_id" => 20
        ]);

        $response->assertStatus(404);
    }

    public function test_upload_nova_imagem_catalogo_sem_catalogo()
        {

            Storage::fake('imagens/1');
            $response = $this->withHeaders([
                'Authorization' =>  $this->token,
            ])->post('/api/imagem',
            [
                "file" => UploadedFile::fake()->image('teste.jpg'),
                "titulo" => "Titulo teste",
                "descricao" => "Descrição de teste",
            ]);

            $response->assertStatus(400);
    }

    public function test_delete_imagem()
    {
        Storage::fake('imagens/1');
        UploadedFile::fake()->image('teste.jpg');
        $response = $this->withHeaders([
            'Authorization' =>  $this->token,
        ])->delete('/api/imagem/' .$this->imagem->id);
        $response->assertStatus(200);
    }

    public function test_delete_imagem_que_nao_cadastrado()
    {

        $response = $this->withHeaders([
            'Authorization' =>  $this->token,
        ])->delete('/api/imagem/2');
        $response->assertStatus(404);
    }

    public function test_edit_imagem()
    {

        $response = $this->withHeaders([
            'Authorization' =>  $this->token,
        ])->patch('/api/imagem',
        [
            "id" => $this->imagem->id,
            "titulo" => "Titulo teste",
            "descricao" => "Descrição de teste",
            "ordem" => 2,
            "principal" => false,
            "catalogo_id" => $this->catalogo->id
        ]);

        $response->assertStatus(200);
    }

    public function test_busca_imagem_por_id()
    {

        $response = $this->withHeaders([
            'Authorization' =>  $this->token,
        ])->get('/api/imagem/' .$this->imagem->id);

        $response->assertStatus(200);
        $response->assertJsonPath("ordem", $this->imagem->ordem);
        $response->assertJsonPath("id", $this->imagem->id);
    }

    public function test_busca_imagem_por_id_nao_cadastrado()
    {

        $response = $this->withHeaders([
            'Authorization' =>  $this->token,
        ])->get('/api/imagem/20');

        $response->assertStatus(404);
    }
}
