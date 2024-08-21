<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use Illuminate\Mail\Mailables\Attachment;

class GenerateQuote extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     */
    public $cart;
    public $user;
    public $userDetail;
    public $priceOption;
    public function __construct($cart, $user, $user_detail, $price_option)
    {
        $this->cart = $cart;
        $this->user = $user;
        $this->userDetail = $user_detail;
        $this->priceOption = $price_option;
    }
    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            from:'quotes@bodypoint.com',
            subject: 'Generate Quote',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'mail.generate-quote',
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        $filePath = storage_path('app/public/quotes/quote-generate' . $this->user->id . '.pdf');
        return [
            Attachment::fromPath($filePath)
                ->as('Quote.pdf')
                ->withMime('application/pdf'),
        ];
    }
}
