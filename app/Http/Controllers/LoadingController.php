<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class LoadingController extends Controller
{
    /**
     * Display the loading screen after successful login
     */
    public function show()
    {
        return view('loadingscreen');
    }

    /**
     * Return the role-based dashboard redirect URL for AJAX request
     */
    public function getDashboardUrl(Request $request): JsonResponse
    {
        if (!auth()->check()) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        $user = auth()->user();
        
        $dashboardUrl = match ($user->role) {
            'admin' => route('admin.dashboard'),
            'head' => route('head.dashboard'),
            default => route('staff.dashboard'),
        };

        return response()->json([
            'url' => $dashboardUrl,
            'role' => $user->role,
        ]);
    }
}
