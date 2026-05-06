<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class StaffController extends Controller
{
    public function dashboard()
    {
        $allTasks = \App\Models\Task::with('room')
            ->where('assigned_to', auth()->id())
            ->get();

        $stats = [
            'total' => $allTasks->count(),
            'pending' => $allTasks->where('status', 'pending')->count(),
            'inProgress' => $allTasks->where('status', 'in-progress')->count(),
            'completed' => $allTasks->where('status', 'completed')->count(),
        ];

        $tasks = \App\Models\Task::with('room')
            ->where('assigned_to', auth()->id())
            ->latest()
            ->paginate(5);

        return view('staff.dashboard', compact('tasks', 'stats'));
    }
}
