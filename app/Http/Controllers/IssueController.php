<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Issue;
use App\Models\Room;
use App\Models\Task;

class IssueController extends Controller
{
    public function create()
    {
        $tasks = Task::with('room')
            ->where('assigned_to', auth()->id())
            ->latest()
            ->get();

        return view('staff.issue-create', compact('tasks'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'task_id' => 'required|exists:tasks,id',
            'description' => 'required|string'
        ]);

        $issue = Issue::create([
            'task_id' => $request->task_id,
            'reported_by' => auth()->id(),
            'description' => $request->description,
            'status' => 'open'
        ]);

        $task = Task::with('room')->find($request->task_id);
        if ($task?->room) {
            $task->room->status = 'For Maintenance';
            $task->room->save();
        }

        return back()->with('success', 'Issue reported! Room set to maintenance.');
    }
}