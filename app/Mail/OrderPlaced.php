<?php

namespace App\Mail;

use App\Models\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Attachment;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class OrderPlaced extends Mailable
{
    use Queueable, SerializesModels;

    public $order;
    protected $pdfData;

    public function __construct(Order $order, $pdfData)
    {
        $this->order = $order;
        $this->pdfData = $pdfData;
    }

    public function envelope(): Envelope
    {
        return new Envelope(subject: 'Your Ethereal Jewelry Order Confirmation - #' . $this->order->order_number);
    }

    public function content(): Content
    {
        return new Content(view: 'emails.placed');
    }

    public function attachments(): array
    {
        return [
            Attachment::fromData(fn () => $this->pdfData, 'Ethereal-Jewelry-Receipt-' . $this->order->order_number . '.pdf')
                ->withMime('application/pdf'),
        ];
    }
}