<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    public function index()
    {
        return view('auth.login');
    }

    public function login(LoginRequest $request)
    {
        $credentials = $request->validated();
        $remember = $request->boolean('remember');

        if (Auth::attempt([
            'email' => $credentials['email'],
            'password' => $credentials['password']
        ], $remember)) {

            $user = Auth::user();

            if ($user->hasRole('provider') && $user->status !== 'approved') {

                Auth::logout();

                return response()->json([
                    'ok' => false,
                    'status' => $user->status,
                    'message' => match ($user->status) {
                        'pending' => 'Tu cuenta está pendiente de aprobación.',
                        'rejected' => 'Tu cuenta fue rechazada.',
                    }
                ], 403);
            }

            $request->session()->regenerate();

            return response()->json([
                'ok' => true,
                'message' => 'Inicio de sesión exitoso',
                'redirect' => '/'
            ]);
        }

        return response()->json([
            'ok' => false,
            'message' => 'Credenciales inválidas'
        ], 401);
    }
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();


        return response()->json(['ok' => true, 'message' => 'Sesión cerrada correctamente'], 200);
    }
}
