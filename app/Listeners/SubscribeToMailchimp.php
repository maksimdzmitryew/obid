<?php

namespace App\Listeners;

use App\Events\UserRegistered;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class SubscribeToMailchimp
{
    private $mailchimp;

    /**
     * Handle the event.
     *
     * @param  UserRegistered  $event
     * @return void
     */
    public function handle(UserRegistered $event)
    {
        $this->mailchimp = new \Mailchimp(config('mail.chimp.apikey'));
        $this->mailchimp->lists->subscribe(
            config('mail.chimp.list_subscribe'),
            [ 'email' => $event->user->email ],
            null, #$event->user->name,				#$merge_vars
            null,									#$email_type, 'html'
            true,									#$double_optin
            false,									#$update_existing
            true,									#$replace_interests
            true									#$send_welcome
        );
    }
}
