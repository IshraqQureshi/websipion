<?php

namespace App\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Mail;
use App\Events\WebsiteAddEvent;
class WebsiteAddEventNotification
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
    public function handle(WebsiteAddEvent $event): void
    {
        // dd();
        $data = explode(',',$event->data->email_cc_recipients);
        // dd($data);
        foreach($data as $mails){
            Mail::send('emails.add_website_mail',$data,function($message) use($data){
                $message->to($mails);
                $message->subject('Website Added');
            });
        }

    }
}
