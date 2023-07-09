<?php

namespace Database\Factories\Catalogo;

use Illuminate\Database\Eloquent\Factories\Factory;

 
class TagFactory extends Factory
{
 
    public function definition()
    {
        return [
            "id" => 1,
            "nome" => "Tag fake",
            "categoria_tag_id" => 1
        ];
    }
}
