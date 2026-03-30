<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\StoreRegisterRequest;
use App\Models\User;
use Illuminate\Support\Facades\Log;

class RegisterController extends Controller
{
    public function index()
    {
        return view('auth.register');
    }
    
    public function store(StoreRegisterRequest $request)
    {
        $response = ['ok' => false, 'message' => 'Error al registrar.'];
        $statusCode = 422;
        try {
            $data = $request->validated();
            $data['status'] = 'pending'; // Establecer estado como pendiente
            $user = User::create($data);
            $user -> assignRole('provider');
            $response = ['ok' => true, 'message' => 'Registro exitoso. Tu cuenta está pendiente de aprobación.'];
            $statusCode = 201;
        } catch (\Exception $e) {
            Log::error('Error al registrar usuario: ' . $e->getMessage());
        }
        return response()->json($response, $statusCode);
    }
}
