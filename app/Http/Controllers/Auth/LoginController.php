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
        $response = ['ok' => false, 'message' => 'Credenciales inválidas'];
        $statusCode = 401;
        $credentials = $request->only('email', 'password');
        $remember = $request->boolean('remember');

        if (Auth::attempt($credentials, $remember)) {
            $request->session()->regenerate();
            $response = ['ok' => true, 'message' => 'Inicio de sesión exitoso'];
            $statusCode = 200;
        }

        return response()->json($response, $statusCode);
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();


        return response()->json(['ok' => true, 'message' => 'Sesión cerrada correctamente'], 200);
    }
}
