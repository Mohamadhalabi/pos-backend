<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ComplainsMail extends Mailable
{
    use Queueable, SerializesModels;

    public $data;
    public $fromEmail;
    public $nameEmail;

    /**
     * Create a new message instance.
     *
     * @param array $data
     * @param string $fromEmail
     * @return void
     */
    public function __construct($data, $fromEmail, $nameEmail)
    {
        $this->data = $data;
        $this->fromEmail = $fromEmail;
        $this->nameEmail = $nameEmail;
    }

    /**
     * Get the message envelope.
     *
     * @return \Illuminate\Mail\Mailables\Envelope
     */
    public function envelope()
    {
        return new Envelope(
            subject: 'شكوى جديدة',
        );
    }

    /**
     * Get the message content definition.
     *
     * @return \Illuminate\Mail\Mailables\Content
     */
    public function content()
    {
        return new Content(
            view: 'email.complains', // Specify the view
            with: ['data' => $this->data] // Pass data to the view
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array
     */
    public function attachments()
    {
        return [];
    }
}