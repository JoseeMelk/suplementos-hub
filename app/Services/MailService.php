<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Mail;
use App\Mail\Auth\WelcomePendingMail;
use App\Mail\Auth\AccountApprovedMail;
use App\Mail\Auth\AccountRejectedMail;

class MailService
{
    /**
     * Notifica al usuario que su cuenta está pendiente de aprobación.
     */
    public function sendWelcomePending(User $user): void
    {
        Mail::to($user->email)->send(new WelcomePendingMail($user));
    }

    /**
     * Notifica al usuario que su cuenta fue aprobada.
     */
    public function sendAccountApproved(User $user): void
    {
        Mail::to($user->email)->send(new AccountApprovedMail($user));
    }

    /**
     * Notifica al usuario que su cuenta fue rechazada.
     */
    public function sendAccountRejected(User $user, ?string $reason = null): void
    {
        Mail::to($user->email)->send(new AccountRejectedMail($user, $reason));
    }
}