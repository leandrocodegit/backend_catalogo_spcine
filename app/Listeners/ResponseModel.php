<?php

namespace App\Listeners;

use App\Events\EventResponse;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use App\Models\Catalogo\Preco;
use App\Models\Catalogo\Catalogo;

class ResponseModel
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }
 
    public function handle(EventResponse $event)
    {

     
    }
}
