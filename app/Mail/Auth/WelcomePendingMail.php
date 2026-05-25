<?php

namespace App\Mail\Auth;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class WelcomePendingMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(public User $user) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Registro recibido — Tu cuenta está en revisión',
        );
    }

    public function content(): Content
    {
        return new Content(
            markdown: 'emails.auth.welcome-pending',
            with: [
                'userName' => $this->user->display_name ?? $this->user->name,
            ],
        );
    }
}