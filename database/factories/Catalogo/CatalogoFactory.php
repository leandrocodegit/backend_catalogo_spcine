<?php

namespace Database\Factories\Catalogo;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Catalogo\Catalogo>
 */
class CatalogoFactory extends Factory
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
            "nome" => "Praça da sé",
            "status" => 1,
            "like" => "Praça da sé",
            "like_langue" => "Praça da sé",
            "endereco" => "Rua serra da prata, cooperativa, São Bernardo do Campo - SP",
            "home" => 1,
            "active" => 1,
            "regiao_id" => 1,
            "categoria_id" => 1,
            "administrador_id" => 1,
            "cordenadas_id" => 1,
            "user_id" => 1,

        ];
    }
}
