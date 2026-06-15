<?php

namespace App\Http\Resources\Support\Tickets;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Resources\Json\JsonResource;

class MessageResource extends JsonResource
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
            'message' => $this->message,
            'sender_id' => $this->sender_id,
            'sender_name' => $this->sender->name,    // evita un join en el front
            'is_mine'     => $this->sender_id === Auth::id(), // booleano directo para "sent"/"recv"
            // 'created_at_human' => $this->created_at?->format('h:i A'), // "10:34 AM"

            'created_at' => $this->created_at?->toISOString(),
        ];
    }
}
