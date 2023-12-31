<?php

namespace Database\Factories\Catalogo;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Catalogo\Regra>
 */
class RegraFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            "id" => 1,
            "tipo_id" => 1,
            "imagem" => '/icon',
            "descricao" => 'Descricao regra'
        ];
    }
}
