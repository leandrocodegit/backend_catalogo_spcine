<?php

namespace Database\Factories\Catalogo;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Catalogo\CategoriaCatalogo>
 */
class CategoriaCatalogoFactory extends Factory
{

    public function definition()
    {
        return [
            'id' => 1,
            'nome' => 'Categoria fake'
        ];
    }
}
