<?php

namespace App\Http\Controllers\Admin\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\Admin\User\UserApiRequest;
use App\Http\Requests\Admin\User\UpdateUserStatusRequest;
use App\Models\User;
use Illuminate\Support\Facades\Log;

class UserController extends Controller
{
    public function api(UserApiRequest $request)
    {
        $response   = ['ok' => false, 'message' => 'Error en la solicitud'];
        $statusCode = 422;

        try {
            $users = User::query()
                ->role('provider')
                ->when($request->status === 'pending',  fn($q) => $q->isPending())
                ->when($request->status === 'approved', fn($q) => $q->isApproved())
                ->when($request->status === 'rejected', fn($q) => $q->isRejected())
                ->when(
                    $request->search,
                    fn($q, $search) =>
                    $q->where(
                        fn($q2) =>
                        $q2->where('name', 'like', "%$search%")
                            ->orWhere('email', 'like', "%$search%")
                    )
                )
                ->latest()
                ->paginate($request->per_page ?? 15);

            // Transformar cada usuario según su status
            $data = collect($users->items())->map(fn($user) => array_filter([
                'id'             => $user->id,
                'name'           => $user->name,
                'email'          => $user->email,
                'status'         => $user->status,
                'created_at'     => $user->created_at,
                'catalog_active' => $user->status === 'approved' ? (bool) $user->catalog_active : null,
            ], fn($value) => $value !== null));

            $response = [
                'ok'   => true,
                'data' => $data,
                'meta' => [
                    'current_page' => $users->currentPage(),
                    'last_page'    => $users->lastPage(),
                    'per_page'     => $users->perPage(),
                    'total'        => $users->total(),
                ],
            ];
            $statusCode = 200;
        } catch (\Exception $e) {
            Log::error('Error en UserController@api: ' . $e->getMessage());
        }

        return response()->json($response, $statusCode);
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('admin.user.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateUserStatusRequest $request, User $user)
    {
        $response = ['ok' => false, 'message' => 'Error al actualizar el estado del usuario'];
        $statusCode = 500;

        try {
            $user->update($request->validated());

            $response = ['ok' => true, 'message' => 'Estado del usuario actualizado correctamente'];
            $statusCode = 200;
        } catch (\Exception $e) {
            Log::error('Error en UserController@update: ' . $e->getMessage());
        }

        return response()->json($response, $statusCode);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
