<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class Upgrade extends Mailable
{
    use Queueable, SerializesModels;
    public $locksmith;
    public $process;
    public $remarks;
    public $status;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($l, $p)
    {
        $this->locksmith = $l;
        $this->process = $p;

        if($p->status == "rejected"){
            $this->status = "Declined";
        }else{
            $this->status = "Approved";
        }

        if($p->remarks == null){
            $this->remarks = "N/A";
        }else{
            $this->remarks = $p->remarks;
        }
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('emails.upgrade');
    }
}
