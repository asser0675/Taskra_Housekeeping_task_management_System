<?php

namespace App\Http\Controllers;

use App\Models\Issue;
use App\Models\Task;

class NotificationController extends Controller
{
    public function index()
    {
        $tasks = Task::with('room')
            ->where('assigned_to', auth()->id())
            ->latest()
            ->take(10)
            ->get();

        $issues = Issue::with(['task.room'])
            ->where('reported_by', auth()->id())
            ->latest()
            ->take(10)
            ->get();

        return view('staff.notifications', compact('tasks', 'issues'));
    }
}