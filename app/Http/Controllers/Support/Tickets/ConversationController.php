<?php

namespace App\Http\Controllers\Support\Tickets;

use App\Http\Controllers\Controller;
use App\Http\Resources\Support\Tickets\ConversationResource;
use App\Models\Conversation;
use Illuminate\Support\Facades\Auth;
use App\Enums\TicketStatus;

class ConversationController extends Controller
{
    /**
     * ADMIN:
     * conversaciones asignadas a él
     */
    public function index()
    {
        $user = Auth::user();

        $conversations = Conversation::whereHas('ticket', function ($query) use ($user) {
            $query->where('assigned_to', $user->id);
        })
        ->with('ticket')
        ->latest('last_message_at')
        ->get();

        return response()->json([
            'ok' => true,
            'data' => ConversationResource::collection($conversations)
        ]);
    }

    /**
     * PROVIDER:
     * conversación activa (ticket en progreso)
     */
    public function active()
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();

        $ticket = $user->tickets()
            ->where('status', TicketStatus::IN_PROGRESS)
            ->first();

        if (!$ticket || !$ticket->conversation) {
            return response()->json([
                'ok' => false,
                'message' => 'No tienes conversación activa'
            ], 404);
        }

        return response()->json([
            'ok' => true,
            'data' => new ConversationResource($ticket->conversation)
        ]);
    }

    /**
     * DETALLE (opcional compartido)
     */
    public function show(Conversation $conversation)
    {
        $conversation->load('ticket');

        return response()->json([
            'ok' => true,
            'data' => new ConversationResource($conversation)
        ]);
    }
}