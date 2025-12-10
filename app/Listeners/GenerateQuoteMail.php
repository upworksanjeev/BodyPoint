<?php

namespace App\Listeners;

use App\Events\GenerateQuote;
use App\Mail\GenerateQuote as MailGenerateQuote;
use Exception;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class GenerateQuoteMail
{
    /**
     * Handle the event.
     */
    public function handle(GenerateQuote $event): void
    {
        try{
            $cart = $event->cart;
            $user_detail = $event->user_detail;
            $price_option = $event->price_option;
            $user = $event->user;
            $include_pdf = $event->include_pdf ?? true;
            Mail::to($event->user)->send(new MailGenerateQuote($cart, $user, $user_detail, $price_option, $include_pdf));
            Mail::to(config('bodypoint.mail_for_quote'))->send(new MailGenerateQuote($cart, $user, $user_detail, $price_option, $include_pdf));
        } catch (Exception $e) {
            Log::error('Error sending Generate Quote email: ' . $e->getMessage());
        }
    }
}
