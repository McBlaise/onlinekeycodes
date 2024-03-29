<?php

namespace App\Mail;

use App\Locksmith;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class Welcome extends Mailable
{
    use Queueable, SerializesModels;

    public $locksmith;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($locksmith)
    {
        $this->locksmith = $locksmith;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('emails.welcome');
    }
}
