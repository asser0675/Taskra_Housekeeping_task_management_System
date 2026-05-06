<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class loginController extends Controller
{
    protected function redirectTo()
    {
        $user = auth()->user();

        if ($user->role == 'admin') {
            return '/admin/dashboard';
        } elseif ($user->role == 'head') {
            return '/head/dashboard';
        } else {
            return '/staff/dashboard';
        }
    }
}
