<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Task;
use App\Models\Room;

class TaskController extends Controller
{
    public function index()
    {
        $tasks = Task::with('room')
            ->where('assigned_to', auth()->id())
            ->latest()
            ->paginate(5);

        return view('staff.tasks', compact('tasks'));
    }


    public function show($id)
    {
        $task = Task::with('room')->findOrFail($id);

        return view('staff.task-show', compact('task'));
    }

    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:pending,in-progress,completed'
        ]);

        $task = Task::where('id', $id)
            ->where('assigned_to', auth()->id())
            ->firstOrFail();

        $task->status = $request->status;
        $task->save();

        $room = $task->room;

        // 
        if ($room->status !== 'For Maintenance') {

            if ($request->status == 'pending') {
                $room->status = 'Dirty';
            }

            if ($request->status == 'in-progress') {
                $room->status = 'In Progress';
            }

            if ($request->status == 'completed') {
                $room->status = 'Ready';
            }

            $room->save();
        }

        return back()->with('success', 'Task and room status updated!');
    }
}