<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Account\PerfilUsuario;
use App\Models\Account\User;
use App\Models\Catalogo\Administrador;
use App\Models\Catalogo\Caracteristica;
use App\Models\Catalogo\CategoriaCaracteristica;
use App\Models\Catalogo\CategoriaCatalogo;
use App\Models\Catalogo\Icon;
use App\Models\Catalogo\Regiao;
use App\Models\Catalogo\TipoRegra;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        PerfilUsuario::create([
            'id' => 1000,
            'nome' => 'Root',
            'role' => 'ROOT'
        ]);

        PerfilUsuario::create([
            'id' => 2,
            'nome' => 'Administrador',
            'role' => 'ADMIN'
        ]);

        PerfilUsuario::create([
            'id' => 3,
            'nome' => 'Operador',
            'role' => 'GUEST'
        ]);

        PerfilUsuario::create([
            'id' => 4,
            'nome' => 'Cliente',
            'role' => 'CLIENT'
        ]);

        User::create([
            'id' => 1,
            'nome' => 'Root',
            'email' => 'root@root.com.br',
            'password' => '$2y$10$s8kHHuz1INnJ50RK5pHDbe2eYlBlO3xbWHI5MN.Q/PTfRe.s/S2OK',
            'active' => true,
            'email_verificado' => true,
            'perfil_id' => 1000
        ]);

        User::create([
            'id' => 2,
            'nome' => 'Sistema',
            'email' => 'contato@siste,a.com.br',
            'password' => '$2y$10$s8kHHuz1INnJ50RK5pHDbe2eYlBlO3xbWHI5MN.Q/PTfRe.s/S2OK',
            'active' => true,
            'email_verificado' => true,
            'perfil_id' => 2
        ]);

        Regiao::create([
            'id' => 1,
            'nome' => 'Outros'
        ]);

        Regiao::create([
            'nome' => 'Sul'
        ]);

        Regiao::create([
            'nome' => 'Norte'
        ]);

        Regiao::create([
            'nome' => 'Leste'
        ]);

        Regiao::create([
            'nome' => 'Oeste'
        ]);

        Regiao::create([
            'nome' => 'Centro'
        ]);

        Administrador::create([
            'nome' => 'Spcine',
            'active' => true
        ]);

        Administrador::create([
            'nome' => 'Municipal',
            'active' => true
        ]);

        Icon::create([
            'id' => 1,
            'descricao' => "Posição",
            'imagem' => '/default/icon_default.png'
        ]);

        CategoriaCatalogo::create([
            'id' => 1,
            'nome' => "Sem categoria",
        ]);

        CategoriaCaracteristica::create([
            'id' => 1,
            'nome' => "Dias da semana",
        ]);

        Caracteristica::create([
            'id' => 1,
            'nome' => "Domingo",
            'categoria_id' => 1,
        ]);
        Caracteristica::create([
            'id' => 2,
            'nome' => "Segunda-feira",
            'categoria_id' => 1,
        ]);

        Caracteristica::create([
            'id' => 3,
            'nome' => "Terça-feira",
            'categoria_id' => 1,
        ]);

        Caracteristica::create([
            'id' => 4,
            'nome' => "Quarta-feira",
            'categoria_id' => 1,
        ]);

        Caracteristica::create([
            'id' => 5,
            'nome' => "Quinta-feira",
            'categoria_id' => 1,
        ]);

        Caracteristica::create([
            'id' => 6,
            'nome' => "Sexta-feira",
            'categoria_id' => 1,
        ]);

        Caracteristica::create([
            'id' => 7,
            'nome' => "Sabado",
            'categoria_id' => 1,
        ]);



    }
}
