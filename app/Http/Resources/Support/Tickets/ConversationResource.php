<?php

namespace App\Http\Resources\Support\Tickets;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ConversationResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'subject' => $this->subject,
            'last_message_at' => $this->last_message_at,
            'ticket_id' => $this->ticket_id,
            'assigned_to' => $this->ticket?->assignedTo?->name,
            'message_count' => $this->messages()->count(), // para el timeline de actividad
        ];
    }
}
