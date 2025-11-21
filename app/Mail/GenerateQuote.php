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
    public $includePdf;
    public function __construct($cart, $user, $user_detail, $price_option, $include_pdf = true)
    {
        $this->cart = $cart;
        $this->user = $user;
        $this->userDetail = $user_detail;
        $this->priceOption = $price_option;
        $this->includePdf = $include_pdf;
    }
    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            from:config('bodypoint.mail_for_quote'),
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
        // Only attach PDF if includePdf is true and file exists
        if (!$this->includePdf) {
            return [];
        }

        $filePath = storage_path('app/public/quotes/quote-generate' . $this->user->id . '.pdf');
        
        // Check if file exists before attaching
        if (!file_exists($filePath)) {
            return [];
        }

        return [
            Attachment::fromPath($filePath)
                ->as('Quote.pdf')
                ->withMime('application/pdf'),
        ];
    }
}
