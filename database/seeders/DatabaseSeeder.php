<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Account\PerfilUsuario;
use App\Models\Account\User;
use App\Models\Catalogo\Administrador;
use App\Models\Catalogo\CategoriaCatalogo;
use App\Models\Catalogo\Icon;
use App\Models\Catalogo\Regiao;
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

        Regiao::create([
            'id' => 1,
            'nome' => 'Sem região'
        ]);

        Regiao::create([
            'nome' => 'Região sul'
        ]);

        Regiao::create([
            'nome' => 'Região norte'
        ]);

        Regiao::create([
            'nome' => 'Região leste'
        ]);

        Regiao::create([
            'nome' => 'Região oeste'
        ]);

        Regiao::create([
            'nome' => 'Centro'
        ]);

        Administrador::create([
            'nome' => 'Spcine',
            'active' => true
        ]);

        Administrador::create([
            'nome' => 'Prefeitura de São Paulo',
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

    }
}
