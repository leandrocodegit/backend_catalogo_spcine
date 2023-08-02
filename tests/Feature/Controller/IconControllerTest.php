<?php

namespace Controller;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\Feature\Controller\FactoryConfig;
use Tests\TestCase;

class IconControllerTest extends FactoryConfig
{
    public function test_create_novo_icon()
    {
        Storage::fake('icons');

        $response = $this->withHeaders([
            'Authorization' =>  $this->token,
        ])->post('/api/icon',
        [
            "file" => UploadedFile::fake()->image('teste.jpg'),
            "descricao" => "Descricao icon teste"
        ]);

        $response->assertStatus(200);
    }

    public function test_atualizar_icon()
    {
        Storage::fake('icons');

        $response = $this->withHeaders([
            'Authorization' =>  $this->token,
        ])->post('/api/icon',
        [
            "id" => 1,
            "file" => UploadedFile::fake()->image('teste.jpg'),
            "descricao" => "Descricao de icon de teste",
        ]);

        $response->assertStatus(200);
    }

    public function test_atualizar_icon_sem_descricao()
    {
        Storage::fake('icons');

        $response = $this->withHeaders([
            'Authorization' =>  $this->token,
        ])->post('/api/icon',
            [
                "id" => 1,
                "file" => UploadedFile::fake()->image('teste.jpg')
            ]);

        $response->assertStatus(400);
    }

    public function test_atualizar_icon_sem_file()
    {
        Storage::fake('icons');

        $response = $this->withHeaders([
            'Authorization' =>  $this->token,
        ])->post('/api/icon',
            [
                "id" => 1,
                "descricao" => "Descricao de icon de teste",
            ]);

        $response->assertStatus(200);
    }

    public function test_create_novo_icon_sem_descricao()
    {
        $response = $this->withHeaders([
            'Authorization' =>  $this->token,
        ])->post('/api/icon',
        [
            "id" => 1,
        ]);

        $response->assertStatus(400);
    }

    public function test_create_novo_icon_sem_file()
    {
        $response = $this->withHeaders([
            'Authorization' =>  $this->token,
        ])->post('/api/icon',
            [
                "id" => 1,
                "descricao" => "Descricao de icon de teste",
            ]);

        $response->assertStatus(200);
    }

    public function test_associar_icon_cordenada()
    {
        $response = $this->withHeaders([
            'Authorization' =>  $this->token,
        ])->post('/api/icon/associar',
            [
                "icon_id" => 1,
                "catalogo_id" => 1,
            ]);

        $response->assertStatus(200);
    }

    public function test_associar_icon_cordenada_id_condernada_invalido()
    {
        $response = $this->withHeaders([
            'Authorization' =>  $this->token,
        ])->post('/api/icon/associar',
            [
                "icon_id" => 1,
                "catalogo_id" => 10,
            ]);

        $response->assertStatus(404);
    }

    public function test_associar_icon_cordenada_id_icon_invalido()
    {
        $response = $this->withHeaders([
            'Authorization' =>  $this->token,
        ])->post('/api/icon/associar',
            [
                "icon_id" => 10,
                "cordenada_id" => 1,
            ]);

        $response->assertStatus(404);
    }

    public function test_busca_icon_por_id()
    {
        $response = $this->withHeaders([
            'Authorization' =>  $this->token,
        ])->get('/api/icon/1');

        $response->assertStatus(200);
        $response->assertJsonPath("descricao", $this->icon->descricao);
    }


    public function test_busca_icon_por_id_invalido()
    {
        $response = $this->withHeaders([
            'Authorization' =>  $this->token,
        ])->get('/api/icon/100');

        $response->assertStatus(404);
    }


    public function test_delete_icon_por_id()
    {
        $response = $this->withHeaders([
            'Authorization' =>  $this->token,
        ])->delete('/api/icon/1');

        $response->assertStatus(400);
    }

    public function test_delete_icon_por_id_invalido()
    {
        $response = $this->withHeaders([
            'Authorization' =>  $this->token,
        ])->delete('/api/icon/100');

        $response->assertStatus(404);
    }

    public function test_lista_icons()
    {
        $response = $this->withHeaders([
            'Authorization' =>  $this->token,
        ])->get('/api/icon/find/list');

        $response->assertStatus(200);
    }
}

