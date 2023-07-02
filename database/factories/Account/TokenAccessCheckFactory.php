<?php

namespace Database\Factories\Account;

use Illuminate\Database\Eloquent\Factories\Factory;
use Carbon\Carbon;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class TokenAccessCheckFactory extends Factory
{
 
    public function definition()
    {
        return [
            "id" => 1, 
            'user_id' => 1,
            'tipo' => 'CHECK',
            'active' => false,
            'token' => 'EZLASZU1PCaicmzo7Jl4m3hpU14XIlafL1h5hpyhdkTc33LvA8MzQzRVB63V4N2SwrDhFzvK4qBivlecm9YfMdZAYhk6rJzRZzUzANosNdQ4rwWDGiqirmD4adfOAgAHbAbdhwj60kzb8bjd7BNfFTcPSN7bEWfFSOGuLV06eOBUa0KMD7Oo1U0y58ce1lirky2oR6vB31yIkXXaZAPxlasHgFSxCg7Yh61HV7wlEsG8Ew7TTZ7eXPZLmpM4hC',
            'validade' => Carbon:: now() -> addMinutes(10)
        ];
    }
}
