@extends('admin.layouts.app')

@section('page-title', 'Tasks')
@section('page-subtitle', 'Manage housekeeping tasks from the dashboard or this dedicated page.')

@section('content')
    <div class="card page-card">
        <div class="card-header">
            <h2>Task Board</h2>
            <button type="button" class="btn-primary" data-modal-open="task-modal">Create Task</button>
        </div>

        <div class="table-wrap">
            <table class="data-table">
                <thead>
                    <tr>
                        <th>Task</th>
                        <th>Room</th>
                        <th>Assigned To</th>
                        <th>Status</th>
                        <th>Priority</th>
                        <th>Deadline</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($tasks as $task)
                        <tr>
                            <td>{{ $task->task_type }}</td>
                            <td>{{ $task->room?->room_number ?? '-' }}</td>
                            <td>{{ $task->housekeeper?->name ?? '-' }}</td>
                            <td>
                                <span class="status-badge {{ $task->status }}">
                                    {{ strtoupper(str_replace('-', ' ', $task->status)) }}
                                </span>
                            </td>
                            <td>
                                <span class="status-badge {{ $task->priority ?? 'Low' }}">
                                    {{ $task->priority ?? '-' }}
                                </span>
                            </td>
                            <td>{{ optional($task->deadline)->format('M d, Y') ?? '-' }}</td>
                            <td class="table-actions">
                                <button type="button" class="text-link" data-modal-open="task-modal" data-modal-action="{{ route('admin.tasks.update', $task) }}" data-modal-method="PUT" data-room-id="{{ $task->room_id }}" data-assigned-to="{{ $task->assigned_to }}" data-task-type="{{ $task->task_type }}" data-status="{{ $task->status }}" data-priority="{{ $task->priority }}" data-deadline="{{ optional($task->deadline)->format('Y-m-d') }}">Edit</button>
                                <form method="POST" action="{{ route('admin.tasks.destroy', $task) }}" onsubmit="return confirm('Delete this task?')" style="display: inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-danger">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="7">No tasks found.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div style="margin-top: 20px; display: flex; justify-content: center;">
            {{ $tasks->onEachSide(1)->links('pagination::custom') }}
        </div>
    </div>

    @include('admin.modals.task')
@endsection