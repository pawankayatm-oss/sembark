<?php

namespace App\Jobs;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use App\Mail\UserCredentialMail;
use Illuminate\Support\Facades\Mail;

class SendUserInvitationMail implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new job instance.
     */
    public $inviteeUserDetail;
    public function __construct($inviteeUserDetail)
    {
        //
        $this->inviteeUserDetail = $inviteeUserDetail;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        //
        Mail::to($inviteeUserDetail->email)->send(new UserCredentialMail($inviteeUserDetail));
    }
}
