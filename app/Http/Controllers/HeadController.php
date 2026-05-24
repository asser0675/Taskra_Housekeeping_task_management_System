<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Task;
use App\Models\User;
use App\Models\Room;
use App\Models\Issue;

class HeadController extends Controller
{
    public function dashboard()
    {
        return view('head.dashboard', [
            'totalTasks' => Task::count(),
            'completed' => Task::where('status', 'completed')->count(),
            'pending' => Task::where('status', 'pending')->count(),
            'inProgress' => Task::where('status', 'in-progress')->count(),

            // For the staff performance table, we get all housekeepers and count how many tasks they've completed
            'staff' => User::where('role', 'housekeeper')
                ->withCount(['tasks as tasks_completed' => function ($q) {
                    $q->where('status', 'completed');
                }])
                ->get(),

            'issues' => Issue::where('status', 'open')->get(),
        ]);
    }

    public function tasks()
    {
        $tasks = Task::select('*')->with(['room', 'housekeeper'])->latest()->paginate(5);
        $rooms = Room::all();
        $staff = User::where('role', 'housekeeper')->get();

        return view('head.tasks', compact('tasks', 'rooms', 'staff'));
    }

    public function schedule()
    {
        $rooms = Room::orderBy('room_number')->get();
        $tasks = Task::select('*')->with(['room', 'housekeeper'])->where('status', 'pending')->paginate(5);

        return view('head.schedule', compact('rooms', 'tasks'));
    }

    public function team()
    {
        $team = User::whereIn('role', ['housekeeper', 'head'])->orderBy('name')->paginate(5);

        return view('head.team', compact('team'));
    }

    public function issues()
    {
        $issues = Issue::with(['task.room', 'reporter'])->latest()->paginate(5);

        return view('head.issues', compact('issues'));
    }

    public function reports()
    {
        $stats = [
            'totalTasks' => Task::count(),
            'completed' => Task::where('status', 'completed')->count(),
            'openIssues' => Issue::where('status', 'open')->count(),
        ];

        return view('head.reports', compact('stats'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'room_id' => 'required|exists:rooms,id',
            'assigned_to' => 'required|exists:users,id',
            'task_type' => 'required',
            'priority' => 'required',
            'deadline' => 'nullable|date',
        ]);

        Task::create([
            'room_id' => $request->room_id,
            'assigned_to' => $request->assigned_to,
            'created_by' => auth()->id(),
            'task_type' => $request->task_type,
            'status' => 'pending',
            'priority' => $request->priority,
            'deadline' => $request->deadline,
        ]);

        return back()->with('success', 'Task created successfully.');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'room_id' => 'required',
            'assigned_to' => 'required',
            'task_type' => 'required',
            'status' => 'required|in:pending,in-progress,completed',
            'priority' => 'required|in:Low,Medium,High',
            'deadline' => 'nullable|date',
        ]);

        $task = Task::findOrFail($id);

        $task->update([
            'room_id' => $request->room_id,
            'assigned_to' => $request->assigned_to,
            'task_type' => $request->task_type,
            'status' => $request->status,
            'priority' => $request->priority,
            'deadline' => $request->deadline,
        ]);

        return back()->with('success', 'Task updated successfully.');
    }

    public function destroy($id)
    {
        Task::findOrFail($id)->delete();

        return back()->with('success', 'Task deleted successfully.');
    }

    public function storeIssue(Request $request)
    {
        abort(403, 'Only staff can create issues.');
    }

    public function updateIssue(Request $request, $id)
    {
        $validated = $request->validate([
            'status' => 'required|in:open,in-progress,resolved',
        ]);

        $issue = Issue::findOrFail($id);

        if ($issue->status === 'resolved') {
            return back()->with('error', 'Resolved issues can no longer be edited.');
        }

        $issue->update([
            'status' => $validated['status'],
        ]);

        return back()->with('success', 'Issue status updated successfully.');
    }

    public function destroyIssue($id)
    {
        Issue::findOrFail($id)->delete();

        return back()->with('success', 'Issue deleted successfully.');
    }
}