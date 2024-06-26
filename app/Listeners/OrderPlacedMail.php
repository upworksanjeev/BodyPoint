<?php

namespace App\Listeners;

use App\Events\OrderPlaced;
use App\Mail\OrderPlaced as MailOrderPlaced;
use Exception;
use Illuminate\Support\Facades\Mail;

class OrderPlacedMail
{
    /**
     * Handle the event.
     */
    public function handle(OrderPlaced $event): void
    {
        $user = $event->order->user;
        Mail::to($user->email)->send(new MailOrderPlaced($event->order));
    }
}
