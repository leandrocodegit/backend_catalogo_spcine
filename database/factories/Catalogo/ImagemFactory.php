<?php

namespace Database\Factories\Catalogo;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Catalogo\Imagem>
 */
class ImagemFactory extends Factory
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
            "titulo" => "Titulo fake",
            "descricao" => "Descrição fake",
            "ordem" => 0,
            "principal" => false,
            "url" => "imagens/2/fake.png",
            "originalName" => "fake.png",
            "hashName" => "fake.png",
            "catalogo_id" => 1,
            "updated_at" => "2023-07-06T00:17:47.000000Z",
            "created_at" => "2023-07-06T00:17:47.000000Z",
        ];
    }
}
