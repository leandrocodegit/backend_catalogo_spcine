<?php

namespace Database\Factories\Catalogo;

use Illuminate\Database\Eloquent\Factories\Factory;


class CaracteristicaFactory extends Factory
{

    public function definition()
    {
        return [
            "id" => 1,
            "nome" => "Caracteristica fake",
            "categoria_id" => 1
        ];
    }
}
