<?php

namespace App\Mail;

use App\Models\Notification;
use App\Models\Etudiant;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class NotificationMail extends Mailable
{
    use Queueable, SerializesModels;

    public $notification;
    public $etudiant;

    public function __construct(Notification $notification, Etudiant $etudiant)
    {
        $this->notification = $notification;
        $this->etudiant = $etudiant;
    }

    public function build()
    {
        return $this->subject($this->notification->titre)
                    ->view('emails.notification')
                    ->with([
                        'notification' => $this->notification,
                        'etudiant' => $this->etudiant,
                    ]);
    }
}
