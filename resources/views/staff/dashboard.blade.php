@extends('staff.layout.app')

@section('page-title', 'Dashboard')
@section('page-subtitle', now()->format('l, d F Y'))

@section('content')
    <div class="welcome-banner">
        <h2 class="welcome-title">
            Hello, {{ auth()->user()->name }}
        </h2>
    </div>

    <div class="stats-grid">
        <div class="stat-card stat-blue">
            <div class="stat-left">
                <div class="stat-icon"><svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="3" width="18" height="18" rx="2" /><path d="M8 7h8" /><path d="M8 11h8" /></svg></div>
                <div><div class="stat-label">TOTAL ASSIGNED</div></div>
            </div>
            <div class="stat-value">{{ $stats['total'] ?? 0 }}</div>
        </div>

        <div class="stat-card stat-orange">
            <div class="stat-left">
                <div class="stat-icon"><svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><path d="M10.29 3.86L1.82 18a2 2 0 001.71 3h16.94a2 2 0 001.71-3L13.71 3.86a2 2 0 00-3.42 0z"/><path d="M12 9v4"/><path d="M12 17h.01"/></svg></div>
                <div><div class="stat-label">PENDING</div></div>
            </div>
            <div class="stat-value">{{ $stats['pending'] ?? 0 }}</div>
        </div>

        <div class="stat-card stat-purple">
            <div class="stat-left">
                <div class="stat-icon"><svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><path d="M3 7h18"/><path d="M3 12h18"/><path d="M3 17h18"/></svg></div>
                <div><div class="stat-label">IN PROGRESS</div></div>
            </div>
            <div class="stat-value">{{ $stats['inProgress'] ?? 0 }}</div>
        </div>

        <div class="stat-card stat-green">
            <div class="stat-left">
                <div class="stat-icon"><svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><path d="M20 6L9 17l-5-5"/></svg></div>
                <div><div class="stat-label">COMPLETED</div></div>
            </div>
            <div class="stat-value">{{ $stats['completed'] ?? 0 }}</div>
        </div>
    </div>

    <div class="task-list-container">
        <div class="task-list-header">
            <h3 class="section-title">My Tasks List</h3>
        </div>

        <div class="table-container">
            <table class="task-table">
                <thead>
                    <tr>
                        <th>Task</th>
                        <th>Room</th>
                        <th>Status</th>
                        <th>Priority</th>
                        <th>Deadline</th>
                        <th>Action</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse($tasks as $task)
                    <tr>
                        <td class="task-title">{{ $task->task_type }}</td>
                        <td class="task-room">{{ $task->room->room_number ?? '' }}</td>

                        <td>
                            <span class="status-badge {{ $task->status }}">
                                {{ strtoupper(str_replace('-', ' ', $task->status)) }}
                            </span>
                        </td>

                        <td>
                            <span class="status-badge {{ $task->priority ?? 'Low' }}">
                                {{ $task->priority ?? 'N/A' }}
                            </span>
                        </td>

                        <td class="task-deadline">{{ $task->deadline?->format('M d, Y') ?? '-' }}</td>

                        <td class="table-actions">
                            @if($task->status == 'pending')
                                <form method="POST" action="{{ route('staff.tasks.update', $task->id) }}" style="display: inline;">
                                    @csrf
                                    <input type="hidden" name="status" value="in-progress">
                                    <button class="action-btn start">Start</button>
                                </form>

                            @elseif($task->status == 'in-progress')
                                <form method="POST" action="{{ route('staff.tasks.update', $task->id) }}" style="display: inline;">
                                    @csrf
                                    <input type="hidden" name="status" value="completed">
                                    <button class="action-btn finish">Finish</button>
                                </form>

                            @else
                                <span class="task-done">Done</span>
                            @endif
                            <a href="{{ route('staff.tasks.show', $task->id) }}" class="action-btn" style="display: inline-block; background-color: #f0f1f9; border-color: #e5e7eb; color: #4a5565; margin-left: 4px;">View</a>
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

        <div style="margin-top: 20px; display: flex; justify-content: center;">
            {{ $tasks->onEachSide(1)->links('pagination::custom') }}
        </div>
    </div>
@endsection