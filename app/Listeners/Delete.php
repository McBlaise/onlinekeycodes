<?php

namespace App\Listeners;

use App\Events\Remove;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class Delete
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

    /**
     * Handle the event.
     *
     * @param  Remove  $event
     * @return void
     */
    public function handle(Remove $event)
    {
        $ls = $event->ls;
        $card = $ls->card();
        $user = $ls->credentials();
        $ls->delete();
        $card->delete();
        $user->delete();
    }
}
