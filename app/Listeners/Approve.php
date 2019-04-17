<?php

namespace App\Listeners;

use App\Events\Verify;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Locksmith;

class Approve
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
     * @param  object  $event
     * @return void
     */
    public function handle(Verify $event)
    {
        $ls = $event->ls;
        $ls->status = 'approved';
        $ls->vcode = '';
        $ls->save();
    }
}
