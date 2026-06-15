<?php

namespace App\Models;

use App\Enums\TicketStatus;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Conversation extends Model
{
    protected $fillable = [
        'subject',
        'last_message_at',
        'ticket_id'
    ];

    protected $casts = [
        'last_message_at' => 'datetime'
    ];

    public function ticket(): BelongsTo
    {
        return $this->belongsTo(Ticket::class);
    }

    public function messages(): HasMany
    {
        return $this->hasMany(Message::class);
    }

    public function scopeAssignedTo($query, int $adminId)
    {
        return $query->whereHas('ticket', function ($q) use ($adminId) {
            $q->where('assigned_to', $adminId);
        });
    }

    public function scopeInProgress($query)
    {
        return $query->whereHas('ticket', function ($q) {
            $q->where('status', TicketStatus::IN_PROGRESS);
        });
    }

    public function scopeActive($query)
    {
        return $query->whereHas('ticket', function ($q) {
            $q->active();
        });
    }
}
