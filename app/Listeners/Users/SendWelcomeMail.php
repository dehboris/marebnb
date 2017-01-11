<?php

namespace App\Listeners\Users;

use App\Events\Users\UserWasRegistered;
use App\Mail\WelcomeMail;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Mail;

class SendWelcomeMail
{
    /**
     * Handle the event.
     *
     * @param  UserWasRegistered  $event
     * @return void
     */
    public function handle(UserWasRegistered $event)
    {
        $user = $event->user;

        Mail::to($user)->queue(new WelcomeMail($user));
    }
}
