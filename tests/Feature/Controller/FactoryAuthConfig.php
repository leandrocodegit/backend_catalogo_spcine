<?php

namespace  Tests\Feature\Controller;


use App\Models\Account\PerfilUsuario;
use App\Models\Account\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Tymon\JWTAuth\Facades\JWTAuth;

class FactoryAuthConfig extends TestCase
{

    use RefreshDatabase;

    protected string $token;
    protected $perfil;
    protected $user;

    public function setUp(): void
    {
        parent::setUp();
        $this->perfil = PerfilUsuario::factory()->create();
        $this->user = User::factory()->create();

        $this->token = 'Bearer ' .JWTAuth::fromUser($this->user);
    }

}
