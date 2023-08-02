<?php

namespace Tests\Feature\Controller;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class RegraControllerTest extends FactoryConfig
{
    public function test_create_regra_tag()
    {
        Storage::fake('regras');

        $response = $this->withHeaders([
            'Authorization' =>  $this->token,
        ])->post('/api/regra',
        [
            "tipo_id" => 1,
            "file" => UploadedFile::fake()->image('teste.jpg'),
            "descricao" => "Descricao regra teste"
        ]);

        $response->assertStatus(200);
    }

    public function test_atualizar_regra_tag()
    {
        Storage::fake('regras');

        $response = $this->withHeaders([
            'Authorization' => $this->token,
        ])->post('/api/regra',
            [
                "id" => 1,
                "tipo_id" => 1,
                "file" => UploadedFile::fake()->image('teste.jpg'),
                "descricao" => "Descricao de regra de teste",
            ]);

        $response->assertStatus(200);
    }

    public function test_atualizar_regra_sem_file()
    {
        $response = $this->withHeaders([
            'Authorization' =>  $this->token,
        ])->post('/api/regra',
            [
                "id" => 1,
                "tipo_id" => 1,
                "descricao" => "Descricao regra teste"
            ]);

        $response->assertStatus(200);
    }

    public function test_atualizar_regra_sem_descricao()
    {
        $response = $this->withHeaders([
            'Authorization' =>  $this->token,
        ])->post('/api/regra',
            [
                "id" => 1,
                "tipo_id" => 1
            ]);

        $response->assertStatus(400);
    }

    public function test_atualizar_regra_tipo_invalido()
    {
        $response = $this->withHeaders([
            'Authorization' =>  $this->token,
        ])->post('/api/regra',
            [
                "id" => 1,
                "tipo_id" => 2
            ]);

        $response->assertStatus(400);
    }


    public function test_atualizar_regra_sem_tipo()
    {
        $response = $this->withHeaders([
            'Authorization' =>  $this->token,
        ])->post('/api/regra',
            [
                "id" => 1
            ]);

        $response->assertStatus(400);
    }

    public function test_create_nova_regra_sem_descricao()
    {
        $response = $this->withHeaders([
            'Authorization' =>  $this->token,
        ])->post('/api/regra',
        [
            "id" => 1,
        ]);

        $response->assertStatus(400);
    }


    public function test_busca_regra_por_id()
    {
        $response = $this->withHeaders([
            'Authorization' =>  $this->token,
        ])->get('/api/regra/1');

        $response->assertStatus(200);
        $response->assertJsonPath("nome", $this->regra->nome);
    }


    public function test_busca_regra_por_id_invalido()
    {
        $response = $this->withHeaders([
            'Authorization' =>  $this->token,
        ])->get('/api/regra/100');

        $response->assertStatus(404);
    }


    public function test_delete_regra_por_id()
    {
        $response = $this->withHeaders([
            'Authorization' =>  $this->token,
        ])->delete('/api/regra/1');

        $response->assertStatus(200);
    }

    public function test_delete_regra_por_id_invalido()
    {
        $response = $this->withHeaders([
            'Authorization' =>  $this->token,
        ])->delete('/api/regra/100');

        $response->assertStatus(404);
    }

    public function test_lista_regras()
    {
        $response = $this->withHeaders([
            'Authorization' =>  $this->token,
        ])->get('/api/tipo/regra/find/list');

        $response->assertStatus(200);
    }
}

