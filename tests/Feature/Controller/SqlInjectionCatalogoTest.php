<?php

namespace Controller;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\Feature\Controller\FactoryAuthConfig;

class SqlInjectionCatalogoTest extends FactoryAuthConfig

{
    use RefreshDatabase;

    public function test_busca_catalogo_injection_select()
    {

        $response = $this->withHeaders([
            'Authorization' => $this->token,
        ])->post('/api/catalogo/filter/list',
            [
                "nome"  => 'SELECT'
            ]);

        $response->assertStatus(401);
    }

    public function test_busca_catalogo_injection_select_ignore_case()
    {

        $response = $this->withHeaders([
            'Authorization' => $this->token,
        ])->post('/api/catalogo/filter/list',
            [
                "nome"  => 'select'
            ]);

        $response->assertStatus(401);
    }

    public function test_busca_catalogo_injection_union()
    {

        $response = $this->withHeaders([
            'Authorization' => $this->token,
        ])->post('/api/catalogo/filter/list',
            [
                "nome"  => 'UNION'
            ]);

        $response->assertStatus(401);
    }

    public function test_busca_catalogo_injection_where()
    {

        $response = $this->withHeaders([
            'Authorization' => $this->token,
        ])->post('/api/catalogo/filter/list',
            [
                "nome"  => 'WHERE'
            ]);

        $response->assertStatus(401);
    }

    public function test_busca_catalogo_injection_delete()
    {

        $response = $this->withHeaders([
            'Authorization' => $this->token,
        ])->post('/api/catalogo/filter/list',
            [
                "nome"  => 'DELETE'
            ]);

        $response->assertStatus(401);
    }

    public function test_busca_catalogo_injection_join()
    {

        $response = $this->withHeaders([
            'Authorization' => $this->token,
        ])->post('/api/catalogo/filter/list',
            [
                "nome"  => 'JOIN'
            ]);

        $response->assertStatus(401);
    }
}
