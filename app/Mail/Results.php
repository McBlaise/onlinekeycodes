<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class Results extends Mailable
{
    use Queueable, SerializesModels;
    public $locksmith;
    public $transaction;
    public $remarks;
    public $status;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($l, $t, $p)
    {
        $this->locksmith = $l;
        $this->transaction = $t;

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
        // return response()->json(['msg'=>'sending...', 'locksmith'=>$this->locksmith, 'transaction'=>$this->transaction, 'process'=>$this->process, 'status'=>$this->status], 200);
        return $this->view('emails.result');
    }
}
