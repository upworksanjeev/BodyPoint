<?php

namespace App\Listeners;

use App\Events\OrderPlaced;
use App\Mail\OrderPlaced as MailOrderPlaced;
use Exception;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class OrderPlacedMail
{
    /**
     * Handle the event.
     */
    public function handle(OrderPlaced $event): void
    {
        try{
            $user = $event->order->user;
            Mail::to($user->email)
            ->cc(config('bodypoint.mail_orders_cc'))
            ->send(new MailOrderPlaced($event->order));
        } catch (Exception $e) {
            Log::error('Error sending order placed email: ' . $e->getMessage());
        }
    }
}
