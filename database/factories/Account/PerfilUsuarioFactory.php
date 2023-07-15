<?php

namespace Database\Factories\Account;

use App\Models\Account\PerfilUsuario;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class PerfilUsuarioFactory extends Factory
{

    protected $model = PerfilUsuario::class;

    public function definition()
    {

        PerfilUsuario::create([
            'id' => 1000,
            'nome' => 'Root',
            'role' => 'ROOT'
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

        return [
            'id' => 2,
            'nome' => 'Administrador',
            'role' => 'ADMIN'
        ];
    }
}
