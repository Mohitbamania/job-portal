<?php

namespace App\Jobs;

use App\Mail\RejectCandidate;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Mail;

class CandidateRejectJob implements ShouldQueue
{
    use Queueable;

    public $mailData;
    public $mail;
    /**
     * Create a new job instance.
     */
    public function __construct($maildata, $mail)
    {
        $this->mailData = $maildata;
        $this->mail = $mail;
    }


    /**
     * Execute the job.
     */
    public function handle(): void
    {
        Mail::to($this->mail)->send(new RejectCandidate($this->mailData));
    }
}
