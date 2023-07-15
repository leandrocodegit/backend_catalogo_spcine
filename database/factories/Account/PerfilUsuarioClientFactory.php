<?php

namespace Database\Factories\Account;

use App\Models\Account\PerfilUsuario;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class PerfilUsuarioClientFactory extends Factory
{

    protected $model = PerfilUsuario::class;
    public function definition()
    {

        return [
            'id' => 4,
            'role' => 'CLIENT',
            'nome' => 'Administrador',
            'updated_at' => '2023-06-30 17:20:58',
            'created_at' => '2023-06-30 17:20:58'
        ];
    }
}
