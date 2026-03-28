<?php

// app/Http/Middleware/EnsureApproved.php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class EnsureApproved
{
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();

        // Solo aplica a proveedores autenticados
        if ($user && $user->hasRole('provider')) {

            if ($user->status === 'pending') {
                Auth::logout();
                $request->session()->invalidate();
                $request->session()->regenerateToken();

                return redirect()->route('login')
                    ->with('info', 'Tu cuenta está pendiente de aprobación. Te avisaremos por correo cuando esté lista.');
            }

            if ($user->status === 'rejected') {
                Auth::logout();
                $request->session()->invalidate();
                $request->session()->regenerateToken();

                return redirect()->route('login')
                    ->with('error', 'Tu solicitud de cuenta fue rechazada. Contacta al administrador para más información.');
            }
        }

        return $next($request);
    }
}