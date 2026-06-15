<?php

namespace App\Http\Resources\Support\Tickets;

use Illuminate\Http\Request;
//use App\Enums\TicketStatus;
use Illuminate\Http\Resources\Json\JsonResource;

class TicketResource extends JsonResource
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
            'title' => $this->title,
            'description' => $this->description,
            'status' => $this->status,
            'tracking_number' => $this->tracking_number,

            'reported_by' => $this->reportedBy?->name,
            'assigned_to' => $this->whenNotNull($this->assignedTo?->name),

            'opened_at' => $this->opened_at,
            'accepted_at' =>  $this->whenNotNull($this->accepted_at),
            'closed_at' => $this->whenNotNull($this->closed_at),

            'status_label' => $this->status->label(), // ej. "En progreso" en español
            // 'can_be_accepted' => $this->status === TicketStatus::OPEN,
            // 'can_be_closed'   => $this->status === TicketStatus::IN_PROGRESS,
            // 'has_conversation' => $this->conversation !== null,

            // Fechas formateadas para mostrar directo en UI
            // 'opened_at_human'   => $this->opened_at?->diffForHumans(),
            // 'accepted_at_human' => $this->accepted_at?->diffForHumans(),
            // 'closed_at_human'   => $this->closed_at?->diffForHumans(),

            'reported_by_id' => $this->reported_by,
            'assigned_to_id' => $this->whenNotNull($this->assigned_to),
        ];
    }
}
