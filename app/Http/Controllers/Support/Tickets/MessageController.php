<?php

namespace App\Http\Controllers\Support\Tickets;

use App\Enums\TicketStatus;
use App\Http\Controllers\Controller;
use App\Http\Resources\Support\Tickets\MessageResource;
use App\Models\Conversation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MessageController extends Controller
{
    /**
     * LISTAR MENSAJES
     */
    public function index(Conversation $conversation)
    {
        $this->authorizeConversation($conversation);

        $messages = $conversation->messages()
            ->with('sender')
            ->latest()
            ->get();

        return response()->json([
            'ok' => true,
            'data' => MessageResource::collection($messages)
        ]);
    }

    /**
     * ENVIAR MENSAJE
     */
    public function store(
        Request $request,
        Conversation $conversation
    ) {
        $request->validate([
            'message' => ['required', 'string', 'max:1000']
        ]);

        $this->authorizeConversation($conversation);

        $message = $conversation->messages()->create([
            'sender_id' => Auth::id(),
            'message' => $request->message,
        ]);

        // actualizar actividad de conversación
        $conversation->update([
            'last_message_at' => now()
        ]);

        return response()->json([
            'ok' => true,
            'data' => new MessageResource($message)
        ], 201);
    }

    /**
     * VALIDACIÓN CENTRAL
     */
    private function authorizeConversation(Conversation $conversation): void
    {
        $ticket = $conversation->ticket;
        $user = Auth::user();

        // 1. debe estar en progreso
        if ($ticket->status !== TicketStatus::IN_PROGRESS) {
            abort(403, 'Ticket no activo');
        }

        // 2. debe ser participante
        if (
            $ticket->reported_by !== $user->id &&
            $ticket->assigned_to !== $user->id
        ) {
            abort(403, 'No autorizado');
        }
    }
}