<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Issue;
use App\Models\Room;
use App\Models\Task;

class IssueController extends Controller
{
    public function index()
    {
        $issues = Issue::with(['task.room'])
            ->where('reported_by', auth()->id())
            ->latest()
            ->paginate(5);

        return view('staff.issues', compact('issues'));
    }

    public function create()
    {
        $tasks = Task::with('room')
            ->where('assigned_to', auth()->id())
            ->latest()
            ->get();

        $selectedTask = null;
        $requestedTaskId = request('task_id');

        if ($requestedTaskId) {
            $selectedTask = Task::with('room')
                ->where('assigned_to', auth()->id())
                ->where('id', $requestedTaskId)
                ->first();
        }

            $backUrl = request('back_url')
                ?: ($selectedTask
                ? route('staff.tasks.show', $selectedTask->id)
                : route('staff.tasks'));

            return view('staff.issue-create', compact('tasks', 'selectedTask', 'backUrl'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'task_id' => ['required', 'exists:tasks,id'],
            'description' => 'required|string'
        ]);

        $task = Task::with('room')
            ->where('id', $validated['task_id'])
            ->where('assigned_to', auth()->id())
            ->firstOrFail();

        $issue = Issue::create([
            'task_id' => $task->id,
            'reported_by' => auth()->id(),
            'description' => $validated['description'],
            'status' => 'open'
        ]);

        if ($task?->room) {
            $task->room->status = 'For Maintenance';
            $task->room->save();
        }

        return back()->with('success', 'Issue reported! Room set to maintenance.');
    }

    public function update(Request $request, Issue $issue)
    {
        abort_unless($issue->reported_by === auth()->id(), 403);

        if ($issue->status === 'resolved') {
            return back()->with('error', 'Resolved issues can no longer be edited.');
        }

        $validated = $request->validate([
            'description' => ['required', 'string'],
        ]);

        $issue->update([
            'description' => $validated['description'],
        ]);

        return back()->with('success', 'Issue updated successfully.');
    }

    public function destroy(Issue $issue)
    {
        abort_unless($issue->reported_by === auth()->id(), 403);

        $issue->delete();

        return back()->with('success', 'Issue deleted successfully.');
    }
}