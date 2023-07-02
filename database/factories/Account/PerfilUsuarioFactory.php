<?php

namespace Database\Factories\Account;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class PerfilUsuarioFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        
        return [
            'id' => 1, 
            'role' => 'ADMIN',
            'nome' => 'Administrador',
            'updated_at' => '2023-06-30 17:20:58',
            'created_at' => '2023-06-30 17:20:58' 
        ];
    }
}
