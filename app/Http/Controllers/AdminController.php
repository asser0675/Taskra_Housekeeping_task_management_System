<?php

namespace App\Http\Controllers;

use App\Models\HotelSetting;
use App\Models\Issue;
use App\Models\Room;
use App\Models\Task;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;
use Illuminate\Validation\Rule;
use Illuminate\Database\Schema\Blueprint;
use Symfony\Component\HttpFoundation\StreamedResponse;

class AdminController extends Controller
{
    public function dashboard()
    {
        $settings = $this->settingsRecord();

        return view('admin.dashboard', array_merge($this->dashboardData(), [
            'settings' => $settings,
            'rooms' => Room::latest()->take(6)->get(),
            'taskRooms' => Room::orderBy('room_number')->get(),
            'housekeepers' => User::where('role', 'housekeeper')->orderBy('name')->get(),
            'teamMembers' => User::whereIn('role', ['admin', 'head', 'housekeeper'])->orderBy('name')->take(8)->get(),
            'issues' => Issue::with(['task.room', 'reporter'])->latest()->take(6)->get(),
            'tasks' => Task::with(['room', 'housekeeper'])->latest()->take(6)->get(),
            'allUsers' => User::whereIn('role', ['admin', 'head', 'housekeeper'])->orderBy('name')->get(),
        ]));
    }

    public function rooms()
    {
        return view('admin.rooms', [
            'settings' => $this->settingsRecord(),
            'rooms' => Room::latest()->paginate(5),
        ]);
    }

    public function storeRoom(Request $request)
    {
        $validated = $request->validate([
            'room_number' => ['required', 'string', 'max:50', Rule::unique('rooms', 'room_number')],
            'status' => ['required', Rule::in(['Ready', 'Dirty', 'In Progress', 'For Maintenance'])],
        ]);

        Room::create($validated);

        return back()->with('success', 'Room created successfully.');
    }

    public function updateRoom(Request $request, Room $room)
    {
        $validated = $request->validate([
            'room_number' => ['required', 'string', 'max:50', Rule::unique('rooms', 'room_number')->ignore($room->id)],
            'status' => ['required', Rule::in(['Ready', 'Dirty', 'In Progress', 'For Maintenance'])],
        ]);

        $room->update($validated);

        return back()->with('success', 'Room updated successfully.');
    }

    public function destroyRoom(Room $room)
    {
        $room->delete();

        return back()->with('success', 'Room deleted successfully.');
    }

    public function tasks()
    {
        return view('admin.tasks', [
            'settings' => $this->settingsRecord(),
            'tasks' => Task::with(['room', 'housekeeper', 'creator'])->latest()->paginate(5),
            'rooms' => Room::orderBy('room_number')->get(),
            'housekeepers' => User::where('role', 'housekeeper')->orderBy('name')->get(),
        ]);
    }

    public function storeTask(Request $request)
    {
        $validated = $request->validate([
            'room_id' => ['required', 'exists:rooms,id'],
            'assigned_to' => ['required', 'exists:users,id'],
            'task_type' => ['required', 'string', 'max:100'],
            'status' => ['required', Rule::in(['pending', 'in-progress', 'completed'])],
            'priority' => ['required', Rule::in(['Low', 'Medium', 'High'])],
            'deadline' => ['nullable', 'date'],
        ]);

        Task::create($validated + ['created_by' => $request->user()->id]);

        return back()->with('success', 'Task created successfully.');
    }

    public function updateTask(Request $request, Task $task)
    {
        $validated = $request->validate([
            'room_id' => ['required', 'exists:rooms,id'],
            'assigned_to' => ['required', 'exists:users,id'],
            'task_type' => ['required', 'string', 'max:100'],
            'status' => ['required', Rule::in(['pending', 'in-progress', 'completed'])],
            'priority' => ['required', Rule::in(['Low', 'Medium', 'High'])],
            'deadline' => ['nullable', 'date'],
        ]);

        $task->update($validated);

        return back()->with('success', 'Task updated successfully.');
    }

    public function destroyTask(Task $task)
    {
        $task->delete();

        return back()->with('success', 'Task deleted successfully.');
    }

    public function teams()
    {
        return view('admin.teams', [
            'settings' => $this->settingsRecord(),
            'teamMembers' => User::whereIn('role', ['admin', 'head', 'housekeeper'])->latest()->paginate(5),
        ]);
    }

    public function storeTeamMember(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:users,email'],
            'role' => ['required', Rule::in(['admin', 'head', 'housekeeper'])],
            'password' => ['required', 'string', 'min:8'],
        ]);

        User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'role' => $validated['role'],
            'password' => Hash::make($validated['password']),
        ]);

        return back()->with('success', 'Team member added successfully.');
    }

    public function updateTeamMember(Request $request, User $user)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', Rule::unique('users', 'email')->ignore($user->id)],
            'role' => ['required', Rule::in(['admin', 'head', 'housekeeper'])],
            'password' => ['nullable', 'string', 'min:8'],
        ]);

        $user->name = $validated['name'];
        $user->email = $validated['email'];
        $user->role = $validated['role'];

        if (! empty($validated['password'])) {
            $user->password = Hash::make($validated['password']);
        }

        $user->save();

        return back()->with('success', 'Team member updated successfully.');
    }

    public function destroyTeamMember(User $user)
    {
        if ($user->assignedTasks()->exists() || $user->createdTasks()->exists() || $user->reportedIssues()->exists()) {
            return back()->with('error', 'Reassign or remove the user from related records before deleting them.');
        }

        if ($user->id === auth()->id()) {
            return back()->with('error', 'You cannot delete your own account from the admin dashboard.');
        }

        $user->delete();

        return back()->with('success', 'Team member deleted successfully.');
    }

    public function issues()
    {
        return view('admin.issues', [
            'settings' => $this->settingsRecord(),
            'issues' => Issue::with(['task.room', 'reporter'])->latest()->paginate(5),
            'tasks' => Task::with('room')->latest()->get(),
            'reporters' => User::whereIn('role', ['admin', 'head', 'housekeeper'])->orderBy('name')->get(),
        ]);
    }

    public function storeIssue(Request $request)
    {
        $validated = $request->validate([
            'task_id' => ['required', 'exists:tasks,id'],
            'reported_by' => ['required', 'exists:users,id'],
            'description' => ['required', 'string'],
            'status' => ['required', Rule::in(['open', 'in-progress', 'resolved'])],
        ]);

        Issue::create($validated);

        return back()->with('success', 'Issue created successfully.');
    }

    public function updateIssue(Request $request, Issue $issue)
    {
        $validated = $request->validate([
            'task_id' => ['required', 'exists:tasks,id'],
            'reported_by' => ['required', 'exists:users,id'],
            'description' => ['required', 'string'],
            'status' => ['required', Rule::in(['open', 'in-progress', 'resolved'])],
        ]);

        $issue->update($validated);

        return back()->with('success', 'Issue updated successfully.');
    }

    public function destroyIssue(Issue $issue)
    {
        $issue->delete();

        return back()->with('success', 'Issue deleted successfully.');
    }

    public function reports()
    {
        return view('admin.reports', array_merge($this->dashboardData(), [
            'settings' => $this->settingsRecord(),
            'recentTasks' => Task::with(['room', 'housekeeper'])->latest()->take(8)->get(),
            'recentIssues' => Issue::with(['task.room', 'reporter'])->latest()->take(8)->get(),
            'rooms' => Room::latest()->take(8)->get(),
            'teamMembers' => User::whereIn('role', ['admin', 'head', 'housekeeper'])->orderBy('name')->get(),
        ]));
    }

    public function exportReport(): StreamedResponse
    {
        $filename = 'admin-summary-' . now()->format('Y-m-d-His') . '.csv';

        return response()->streamDownload(function () {
            $handle = fopen('php://output', 'w');
            fputcsv($handle, ['Metric', 'Value']);
            fputcsv($handle, ['Total Tasks', Task::count()]);
            fputcsv($handle, ['Completed Tasks', Task::where('status', 'completed')->count()]);
            fputcsv($handle, ['Pending Tasks', Task::where('status', 'pending')->count()]);
            fputcsv($handle, ['In Progress Tasks', Task::where('status', 'in-progress')->count()]);
            fputcsv($handle, ['Open Issues', Issue::where('status', 'open')->count()]);
            fputcsv($handle, ['Rooms', Room::count()]);
            fclose($handle);
        }, $filename, ['Content-Type' => 'text/csv']);
    }

    public function settings()
    {
        return view('admin.settings', [
            'settings' => $this->settingsRecord(),
            'stats' => $this->dashboardData()['stats'],
        ]);
    }

    public function updateSettings(Request $request)
    {
        $validated = $request->validate([
            'hotel_name' => ['required', 'string', 'max:255'],
            'currency' => ['required', 'string', 'max:10'],
            'timezone' => ['required', 'string', 'max:100'],
            'language' => ['required', 'string', 'max:20'],
        ]);

        $settings = $this->settingsRecord();
        $settings->update($validated + [
            'task_notifications' => $request->boolean('task_notifications'),
            'issue_alerts' => $request->boolean('issue_alerts'),
            'email_notifications' => $request->boolean('email_notifications'),
        ]);

        return back()->with('success', 'Settings saved successfully.');
    }

    private function dashboardData(): array
    {
        $totalTasks = Task::count();

        return [
            'stats' => [
                'totalTasks' => $totalTasks,
                'completedTasks' => Task::where('status', 'completed')->count(),
                'pendingTasks' => Task::where('status', 'pending')->count(),
                'inProgressTasks' => Task::where('status', 'in-progress')->count(),
                'totalRooms' => Room::count(),
                'openIssues' => Issue::where('status', 'open')->count(),
                'teamCount' => User::whereIn('role', ['admin', 'head', 'housekeeper'])->count(),
            ],
            'recentTasks' => Task::with(['room', 'housekeeper'])->latest()->take(5)->get(),
            'recentIssues' => Issue::with(['task.room', 'reporter'])->latest()->take(5)->get(),
            'recentRooms' => Room::latest()->take(5)->get(),
        ];
    }

    private function settingsRecord(): HotelSetting
    {
        $this->ensureSettingsTableExists();

        return HotelSetting::query()->first() ?? HotelSetting::create([
            'hotel_name' => 'Taskra Hotel',
            'currency' => 'PHP',
            'timezone' => 'Asia/Manila',
            'language' => 'en',
            'task_notifications' => true,
            'issue_alerts' => true,
            'email_notifications' => false,
        ]);
    }

    private function ensureSettingsTableExists(): void
    {
        if (Schema::hasTable('hotel_settings')) {
            return;
        }

        Schema::create('hotel_settings', function (Blueprint $table): void {
            $table->id();
            $table->string('hotel_name')->default('Taskra Hotel');
            $table->string('currency')->default('PHP');
            $table->string('timezone')->default('Asia/Manila');
            $table->string('language')->default('en');
            $table->boolean('task_notifications')->default(true);
            $table->boolean('issue_alerts')->default(true);
            $table->boolean('email_notifications')->default(false);
            $table->timestamps();
        });
    }
}