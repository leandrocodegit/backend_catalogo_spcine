<?php

namespace Database\Factories\Catalogo;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Catalogo\Preco>
 */
class PrecoFactory extends Factory
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
            'minimo' => 100,
            'maximo' => 200,
            'tabela_descontos' => 'true',
            'tabela_descontos' => 'tabela',
            "descontos" => true,
            "descricao" => 'Descricao regra',
            "catalogo_id" => 1,
        ];
    }
}
