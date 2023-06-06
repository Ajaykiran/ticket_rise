<?php

namespace App\Listeners;

use App\events\mailhandling;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Mail;

class SendMailFired
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {   
        //
    }

    /**
     * Handle the event.
     */
    public function handle(mailhandling $event): void
    {
        $user = $event->user;
       
        mail::send('sendmail', ['user' => $user], function($message) use ($user) {
            $message->to($user->email);
            $message->subject('sample');
        });
    }
    
}
