<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\StoreRegisterRequest;
use App\Models\User;
use App\Services\MailService;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

class RegisterController extends Controller
{
    public function index()
    {
        return view('auth.register');
    }
    
    public function store(StoreRegisterRequest $request, MailService $mailService)
    {
        $response = ['ok' => false, 'message' => 'Error al registrar.'];
        $statusCode = 422;
        try {
            $data = $request->validated();
            $data['status'] = 'pending'; // Establecer estado como pendiente
            DB::beginTransaction();
            $user = User::create($data);
            $user -> assignRole('provider');
            // Enviar correo de bienvenida pendiente
            $mailService->sendWelcomePending($user);
            DB::commit();
            $response = ['ok' => true, 'message' => 'Registro exitoso. Tu cuenta está pendiente de aprobación.'];
            $statusCode = 201;
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error al registrar usuario: ' . $e->getMessage());
        }
        return response()->json($response, $statusCode);
    }
}
