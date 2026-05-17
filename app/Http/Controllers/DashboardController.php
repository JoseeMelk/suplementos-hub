<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $userRoles = $user->getRoleNames();

        return view('dashboard', [
            'user' => $user,
            'isAdmin' => $userRoles->contains('admin'),
            'isProvider' => $userRoles->contains('provider'),
        ]);
    }
}
