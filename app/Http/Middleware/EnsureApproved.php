<?php

// app/Http/Middleware/EnsureApproved.php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureApproved
{
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();

        if ($user && $user->hasRole('provider') && $user->status !== 'approved') {

            if ($request->expectsJson()) {
                return response()->json([
                    'ok' => false,
                    'status' => $user->status,
                    'message' => 'Cuenta no autorizada'
                ], 403);
            }

            return redirect()->route('login');
        }

        return $next($request);
    }
}
