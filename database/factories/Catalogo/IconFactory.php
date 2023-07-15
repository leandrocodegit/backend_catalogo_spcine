<?php

namespace Database\Factories\Catalogo;

use Illuminate\Database\Eloquent\Factories\Factory;

class IconFactory extends Factory
{

    public function definition()
    {
        return [
            'id' => 1,
            'descricao' => 'fake icon',
            'imagem' => 'url fake'
        ];
    }
}
