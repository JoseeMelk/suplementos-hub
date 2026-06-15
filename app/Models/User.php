<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;
use App\Enums\TicketStatus;

#[Fillable([
    'name',
    'email',
    'password',
    'slug',
    'display_name',
    'bio',
    'avatar',
    'status',
    'catalog_active'
])]
#[Hidden(['password', 'remember_token'])]
class User extends Authenticatable
{
    use HasFactory, Notifiable, HasRoles;

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function products()
    {
        return $this->hasMany(Product::class);
    }

    /**
     * Tickets creados por el proveedor
     */
    public function tickets()
    {
        return $this->hasMany(Ticket::class, 'reported_by');
    }

    /**
     * Tickets asignados al admin
     */
    public function assignedTickets()
    {
        return $this->hasMany(Ticket::class, 'assigned_to');
    }

    public function hasActiveTicket(): bool
    {
        return $this->tickets()
            ->active()
            ->exists();
    }

    /**
     * Estados del usuario por scope
     */
    public function scopeIsPending($query)
    {
        return $query->where('status', 'pending');
    }

    public function scopeIsApproved($query)
    {
        return $query->where('status', 'approved');
    }

    public function scopeIsRejected($query)
    {
        return $query->where('status', 'rejected');
    }

    /**
     * Estados del usuario, si esta aprovado, pendiente o rechazado
     */
    public function isApproved(): bool
    {
        return $this->status === 'approved';
    }

    public function isRejected(): bool
    {
        return $this->status === 'rejected';
    }

    public function isPending(): bool
    {
        return $this->status === 'pending';
    }

    /**
     * Ticket actualmente en progreso
     */
    public function getInProgressTicket(): ?Ticket
    {
        return $this->tickets()
            ->where('status', TicketStatus::IN_PROGRESS)
            ->first();
    }

    /**
     * Ticket activo (OPEN o IN_PROGRESS)
     */
    public function getActiveTicket(): ?Ticket
    {
        return $this->tickets()
            ->active()
            ->first();
    }
}
