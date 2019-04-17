<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class PasswordReset extends Mailable
{
    use Queueable, SerializesModels;
    public $locksmith;
    public $password;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($locksmith, $password)
    {
        $this->locksmith = $locksmith;
        $this->password = $password;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('emails.passreset');
    }
}
