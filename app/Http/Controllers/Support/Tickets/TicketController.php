<?php

namespace App\Http\Controllers\Support\Tickets;

use App\Enums\TicketStatus;
use App\Http\Controllers\Controller;
use App\Http\Requests\Support\Tickets\StoreTicketRequest;
use App\Http\Resources\Support\Tickets\TicketResource;
use App\Models\Ticket;
use App\Models\Conversation;
use App\Services\TrackingNumberService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Exception;

class TicketController extends Controller
{

    /**
     * Admin: listado de tickets
     */
    public function index()
    {
        try {
            $user = Auth::user();

            $tickets = Ticket::query()
                ->whereIn('status', [
                    TicketStatus::OPEN,
                    TicketStatus::CLOSED,
                ])
                ->orWhere(function ($query) use ($user) {
                    $query->where('status', TicketStatus::IN_PROGRESS)
                        ->where('assigned_to', $user->id);
                })
                ->latest()
                ->get();

            return response()->json([
                'ok' => true,
                'data' => TicketResource::collection($tickets)
            ]);
        } catch (Exception $e) {
            Log::error('Error al listar tickets @TicketController: ' . $e->getMessage());

            return response()->json([
                'ok' => false,
                'message' => 'Error al listar tickets'
            ], 500);
        }
    }

    /**
     * Provider crea ticket
     */
    public function store(StoreTicketRequest $request, TrackingNumberService $trackingNumberService)
    {
        $user = Auth::user();

        // regla de negocio: solo 1 ticket activo
        $hasActiveTicket = Ticket::where('reported_by', $user->id)
            ->whereIn('status', [
                TicketStatus::OPEN,
                TicketStatus::IN_PROGRESS
            ])
            ->exists();

        if ($hasActiveTicket) {
            return response()->json([
                'ok' => false,
                'message' => 'Ya tienes un ticket abierto o en progreso'
            ], 409);
        }

        $ticket = DB::transaction(function () use ($request, $user, $trackingNumberService) {
            return Ticket::create([
                'title' => $request->title,
                'description' => $request->description,
                'status' => TicketStatus::OPEN,
                'tracking_number' => $trackingNumberService->generateTrackingNumber(),
                'opened_at' => now(),
                'reported_by' => $user->id,
            ]);
        });

        return response()->json([
            'ok' => true,
            'data' => new TicketResource($ticket)
        ], 201);
    }

    /**
     * Admin acepta ticket
     */
    public function update(Ticket $ticket)
    {
        $user = Auth::user();

        if ($ticket->status !== TicketStatus::OPEN) {
            return response()->json([
                'ok' => false,
                'message' => 'Solo puedes aceptar tickets abiertos'
            ], 422);
        }

        DB::transaction(function () use ($ticket, $user) {

            $ticket->update([
                'status' => TicketStatus::IN_PROGRESS,
                'assigned_to' => $user->id,
                'accepted_at' => now(),
            ]);

            // 🔥 CREAR CONVERSACIÓN AUTOMÁTICA
            Conversation::firstOrCreate(
                ['ticket_id' => $ticket->id],
                [
                    'subject' => $ticket->title,
                    'last_message_at' => now(),
                ]
            );
        });

        return response()->json([
            'ok' => true,
            'message' => 'Ticket aceptado correctamente'
        ]);
    }

    /**
     * Provider: ticket activo
     */
    public function myActiveTicket()
    {
        $user = Auth::user();

        $ticket = Ticket::with(['reportedBy', 'assignedTo'])
            ->where('reported_by', $user->id)
            ->whereIn('status', [
                TicketStatus::OPEN,
                TicketStatus::IN_PROGRESS
            ])
            ->latest()
            ->first();

        return response()->json([
            'ok' => true,
            'data' => $ticket ? new TicketResource($ticket) : null
        ]);
    }
    /**
     * Admin
     * cierra ticket
     */
    public function close(Ticket $ticket)
    {
        $user = Auth::user();

        // solo admin asignado
        if ($ticket->assigned_to !== $user->id) {
            abort(403, 'No autorizado');
        }

        if ($ticket->status !== TicketStatus::IN_PROGRESS) {
            return response()->json([
                'ok' => false,
                'message' => 'Solo se pueden cerrar tickets en progreso'
            ], 422);
        }

        DB::transaction(function () use ($ticket) {
            $ticket->update([
                'status' => TicketStatus::CLOSED,
                'closed_at' => now(),
            ]);
        });

        return response()->json([
            'ok' => true,
            'message' => 'Ticket cerrado correctamente'
        ]);
    }
}
