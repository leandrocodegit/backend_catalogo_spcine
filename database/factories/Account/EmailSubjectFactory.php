<?php

namespace Database\Factories\Account;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Account\EmailSubject>
 */
class EmailSubjectFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'mensagem' => 'Fake', 
            'nameBottom' => 'Fake',
            'link' => 'Fake',
            'assunto' => 'Fake' 
        ];
    }
 
}
