@extends('head.layout.app')

@section('page-title', 'Schedule')
@section('page-subtitle', 'View upcoming tasks and manage the schedule.')

@section('content')
    <div class="card page-card">
        <div class="card-header">
            <h2>Scheduled Tasks</h2>
        </div>

        <div class="table-wrap">
            <table class="data-table">
                <thead>
                    <tr>
                        <th>Task</th>
                        <th>Room</th>
                        <th>Assigned To</th>
                        <th>Status</th>
                        <th>Deadline</th>
                        <th>Priority</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($tasks as $task)
                        <tr>
                            <td>{{ $task->task_type }}</td>
                            <td>Room {{ $task->room?->room_number ?? '-' }}</td>
                            <td>{{ $task->housekeeper?->name ?? '-' }}</td>
                            <td>
                                <span class="status-badge {{ $task->status }}">
                                    {{ strtoupper(str_replace('-', ' ', $task->status)) }}
                                </span>
                            </td>
                            <td>{{ optional($task->deadline)->format('M d, Y') ?? '-' }}</td>
                            <td>
                                <span class="status-badge {{ $task->priority ?? 'Low' }}">
                                    {{ $task->priority ?? '-' }}
                                </span>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="6">No scheduled tasks.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{ $tasks->onEachSide(1)->links('pagination::custom') }}
    </div>
@endsection