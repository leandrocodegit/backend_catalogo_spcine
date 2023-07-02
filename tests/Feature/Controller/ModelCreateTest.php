<?php

namespace Tests\Feature\Controller;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Account\User;
use App\Models\Account\PerfilUsuario;

class ModelCreate extends TestCase
{
     
    use RefreshDatabase;

    public function test_create_user_and_perfil()
    { 
        $perfil = PerfilUsuario::factory()->create();
        $user = User::factory()->create();

        $this->assertModelExists($perfil);
        $this->assertModelExists($user);
    }
}
