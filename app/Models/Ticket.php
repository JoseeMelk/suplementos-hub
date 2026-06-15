<?php

namespace App\Models;

use App\Enums\TicketStatus;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Attributes\Fillable;

#[Fillable([
    'title',
    'description',
    'status',
    'tracking_number',
    'opened_at',
    'accepted_at',
    'closed_at',
    'reported_by',
    'assigned_to'
])]
class Ticket extends Model
{
    protected $casts = [
        'status' => TicketStatus::class,
        'opened_at' => 'datetime',
        'accepted_at' => 'datetime',
        'closed_at' => 'datetime',
    ];

    public function conversation()
    {
        return $this->hasOne(Conversation::class);
    }

    public function reportedBy()
    {
        return $this->belongsTo(User::class, 'reported_by');
    }

    public function assignedTo()
    {
        return $this->belongsTo(User::class, 'assigned_to');
    }

    public function scopeOpen($query)
    {
        return $query->where('status', TicketStatus::OPEN);
    }

    public function scopeInProgress($query)
    {
        return $query->where('status', TicketStatus::IN_PROGRESS);
    }

    public function scopeClosed($query)
    {
        return $query->where('status', TicketStatus::CLOSED);
    }

    public function scopeActive($query)
    {
        return $query->whereIn('status', [
            TicketStatus::OPEN,
            TicketStatus::IN_PROGRESS
        ]);
    }
}
