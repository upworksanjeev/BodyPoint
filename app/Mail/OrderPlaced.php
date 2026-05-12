<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Attachment;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class OrderPlaced extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     */
    public $order;
    public $pdfContent;
    public function __construct($order, ?string $pdfContent = null)
    {
        $this->order = $order;
        $this->pdfContent = $pdfContent;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            from:config('bodypoint.mail_for_orders'),
            subject: 'Order Placed',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'mail.order-placed',
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        if (!empty($this->pdfContent)) {
            return [
                Attachment::fromData(fn () => $this->pdfContent, 'order.pdf')
                    ->withMime('application/pdf'),
            ];
        }

        $filePath = storage_path('app/public/orders/order_receipt_' . $this->order->id . '.pdf');
        if (!file_exists($filePath)) {
            return [];
        }

        $fileSize = @filesize($filePath) ?: 0;
        if ($fileSize < 1024) {
            return [];
        }

        $header = @file_get_contents($filePath, false, null, 0, 5);
        if ($header !== '%PDF-') {
            return [];
        }

        return [
            Attachment::fromPath($filePath)
                ->as('order.pdf')
                ->withMime('application/pdf'),
        ];
    }
}
