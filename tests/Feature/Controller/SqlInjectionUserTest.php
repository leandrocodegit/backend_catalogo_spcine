<?php

namespace Controller;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\Feature\Controller\FactoryAuthConfig;

class SqlInjectionUserTest extends FactoryAuthConfig

{
    use RefreshDatabase;

    public function test_busca_usuario_injection_select()
    {

        $response = $this->withHeaders([
            'Authorization' => $this->token,
        ])->post('/api/user/filter/list',
            [
                "nome"  => 'SELECT'
            ]);

        $response->assertStatus(401);
    }

    public function test_busca_usuario_injection_select_ignore_case()
    {

        $response = $this->withHeaders([
            'Authorization' => $this->token,
        ])->post('/api/user/filter/list',
            [
                "nome"  => 'select'
            ]);

        $response->assertStatus(401);
    }

    public function test_busca_usuario_injection_union()
    {

        $response = $this->withHeaders([
            'Authorization' => $this->token,
        ])->post('/api/user/filter/list',
            [
                "nome"  => 'UNION'
            ]);

        $response->assertStatus(401);
    }

    public function test_busca_usuario_injection_where()
    {

        $response = $this->withHeaders([
            'Authorization' => $this->token,
        ])->post('/api/user/filter/list',
            [
                "nome"  => 'WHERE'
            ]);

        $response->assertStatus(401);
    }

    public function test_busca_usuario_injection_delete()
    {

        $response = $this->withHeaders([
            'Authorization' => $this->token,
        ])->post('/api/user/filter/list',
            [
                "nome"  => 'DELETE'
            ]);

        $response->assertStatus(401);
    }

    public function test_busca_usuario_injection_join()
    {

        $response = $this->withHeaders([
            'Authorization' => $this->token,
        ])->post('/api/user/filter/list',
            [
                "nome"  => 'JOIN'
            ]);

        $response->assertStatus(401);
    }
}
