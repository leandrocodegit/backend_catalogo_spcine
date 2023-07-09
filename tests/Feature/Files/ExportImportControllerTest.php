<?php

namespace Tests\Feature\Files;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use App\Models\Account\User;
use App\Models\Account\PerfilUsuario; 
use Maatwebsite\Excel\Facades\Excel; 
use Tymon\JWTAuth\Facades\JWTAuth;

class ExportImportControllerTest extends TestCase
{
    use RefreshDatabase;

    private string $token;
    protected $perfil;
    protected $user; 
    public function setUp(): void
    {
        parent::setUp(); 
        $this->perfil = PerfilUsuario::factory()->create([
            'role' => 'ROOT',
        ]);
        $this->user = User::factory()->create();

        $this->token = 'Bearer ' .JWTAuth::fromUser($this->user);   
    }

    public function test_importação_de_catalogos() 
{
    Excel::fake();
  
    $response = $this->withHeaders([
        'Authorization' =>  $this->token,
    ])->post('/api/data/import/catalogo', 
        [  
            "file" => UploadedFile::fake()->image('teste.xls'), 
        ]); 
 
    $response->assertStatus(200);
}

public function test_importação_de_catalogos_documento_invalido() 
{

    $response = $this->withHeaders([
        'Authorization' =>  $this->token,
    ])->post('/api/data/import/catalogo'); 
 
    $response->assertStatus(422);
}


public function test_exportação_de_catalogos() 
{
    Excel::fake();
  
    $response = $this->withHeaders([
        'Authorization' =>  $this->token,
    ])->get('/api/data/export/catalogo'); 
 
    $response->assertStatus(200);
}


public function test_exportação_de_catalogos_admin() 
{

    $this->perfil->update([
        'role' => 'ADMIN',
    ]);

    Excel::fake();
  
    $response = $this->withHeaders([
        'Authorization' =>  $this->token,
    ])->get('/api/data/export/catalogo'); 
 
    $response->assertStatus(200);
}

public function test_importação_de_usuarios() 
{
    Excel::fake();
  
    $response = $this->withHeaders([
        'Authorization' =>  $this->token,
    ])->post('/api/data/import/usuario', 
        [  
            "file" => UploadedFile::fake()->image('teste.xls'), 
        ]); 
 
    $response->assertStatus(200);
}

public function test_importação_de_usuarios_documento_invalido() 
{
     $response = $this->withHeaders([
        'Authorization' =>  $this->token,
    ])->post('/api/data/import/usuario'); 
 
    $response->assertStatus(422);
}
}
