<?php

namespace App\Mail\Auth;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class AccountRejectedMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public User $user,
        public ?string $reason = null,
    ) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Actualización sobre tu cuenta — Suplementos Hub',
        );
    }

    public function content(): Content
    {
        return new Content(
            markdown: 'emails.auth.account-rejected',
            with: [
                'userName' => $this->user->display_name ?? $this->user->name,
                'reason'   => $this->reason,
            ],
        );
    }
}