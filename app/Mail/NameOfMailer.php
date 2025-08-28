<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class NameOfMailer extends Mailable
{
    use Queueable, SerializesModels;

    public $credentials;

    public function __construct($credentials)
    {
        $this->credentials = $credentials;
    }

    public function build()
    {
        return $this->subject('Your Student Account Credentials')
            ->view('emails.verification')
            ->with([
                'email' => $this->credentials['email'],
                'password' => $this->credentials['password'],
            ]);
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Verify Your Email',
        );
    }

    /**
     * Get the message content definition.
    //  */
    // public function content(): Content
    // {
    //     return new Content(
    //         view: 'emails.verification',
    //         with: ['code' => $this->code] // This makes $code available in the view
    //     );
    // }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}
