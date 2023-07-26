<?php

namespace App\Models\util;

use Illuminate\Support\MessageBag;

class MapError
{

    public function __construct(){
    }

    public static function format(MessageBag $erros){
        return collect($erros)->map(function (array $name) {
            return ($name[0]);
        })->groupBy('nome')->first();
    }


}
