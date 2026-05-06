@extends('staff.layout.app')

@section('page-title', 'My Tasks')
@section('page-subtitle', 'Manage your assigned tasks')

@section('content')
    <div class="card page-card">
        <h3 style="margin-bottom: 20px;">Task List</h3>
        
        <div class="table-wrap">
            <table class="data-table">
                <thead>
                    <tr>
                        <th>Task</th>
                        <th>Room</th>
                        <th>Priority</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($tasks as $task)
                        <tr>
                            <td>
                                <strong>{{ $task->task_type }}</strong>
                            </td>
                            <td>
                                Room {{ $task->room->room_number ?? 'N/A' }}
                            </td>
                            <td>
                                <span class="status-badge {{ $task->priority ?? 'Low' }}">
                                    {{ $task->priority ?? 'N/A' }}
                                </span>
                            </td>
                            <td>
                                <span class="status-badge {{ $task->status }}">
                                    {{ strtoupper(str_replace('-', ' ', $task->status)) }}
                                </span>
                            </td>
                            <td class="table-actions" style="display: flex; gap: 8px; flex-wrap: wrap;">
                                @if($task->status == 'pending')
                                    <form method="POST" action="{{ route('staff.tasks.update', $task->id) }}" style="display: inline;">
                                        @csrf
                                        <input type="hidden" name="status" value="in-progress">
                                        <button class="action-btn start" style="width: auto; margin: 0;">Start</button>
                                    </form>
                                @elseif($task->status == 'in-progress')
                                    <form method="POST" action="{{ route('staff.tasks.update', $task->id) }}" style="display: inline;">
                                        @csrf
                                        <input type="hidden" name="status" value="completed">
                                        <button class="action-btn finish" style="width: auto; margin: 0;">Finish</button>
                                    </form>
                                @else
                                    <span class="task-done">Done</span>
                                @endif
                                <a href="{{ route('staff.tasks.show', $task->id) }}" class="action-btn" style="display: inline-block; background-color: #f0f1f9; border-color: #e5e7eb; color: #4a5565; margin: 0;">View</a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" style="text-align:center; padding:40px 20px; color:#6a7282;">
                                No tasks assigned yet.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div style="margin-top: 20px; display: flex; justify-content: center;">
        {{ $tasks->onEachSide(1)->links('pagination::custom') }}
    </div>
@endsection
