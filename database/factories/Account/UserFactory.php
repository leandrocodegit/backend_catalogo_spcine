<?php

namespace Database\Factories\Account;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
 
    public function definition()
    {
 
        return [
            'id' => env('ID_FAKE'), 
            'nome' => env('NOME_FAKE'),
            'cpf' => env('CPF_FAKE'),
            'email' => env('EMAIL_FAKE'),
            'empresa' => env('EMPRESA_FAKE'),
            'password' => '$2y$10$T395KFqulQVhixaqh7izn.xaBK0cg3In9qt9JvrAppbXloUosr0dG',
            'active' => env('ACTIVE_FAKE'),
            'perfil_id' => env('PERFIL_FAKE'),
        ];
    }
 
    public function unverified()
    {
        return $this->state(fn (array $attributes) => [
            'active' => true,
        ]);
    }
}
