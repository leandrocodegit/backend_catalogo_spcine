<?php

namespace App\Listeners;

use App\Events\EventResponse;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

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
        $output = new \Symfony\Component\Console\Output\ConsoleOutput();
            $output->writeln($event->message .'  '. $event->status); 

            return response()->json([
                'name' => 'Abigail',
                'state' => 'CA',
            ]);
    }
}
