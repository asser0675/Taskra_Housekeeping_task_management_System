@extends('staff.layout.app')

@section('page-title', 'Task Detail')
@section('page-subtitle', 'Task information and actions')

@section('content')
    <div class="card page-card">
        <div class="card-header">
            <h2>Task Detail</h2>
            <a href="{{ route('staff.tasks') }}" class="btn-outline">Back to Tasks</a>
        </div>

        <div class="task-detail-grid">
            <div class="task-main">
                <h3>{{ $task->task_type }}</h3>
                <p><strong>Room:</strong> {{ $task->room?->room_number ?? 'N/A' }}</p>
                <p><strong>Assigned To:</strong> {{ $task->housekeeper?->name ?? 'Unassigned' }}</p>
                <p><strong>Priority:</strong> 
                    <span class="status-badge {{ $task->priority ?? 'Low' }}">
                        {{ $task->priority ?? '-' }}
                    </span>
                </p>
                <p><strong>Status:</strong> 
                    <span class="status-badge {{ $task->status }}">
                        {{ strtoupper(str_replace('-', ' ', $task->status)) }}
                    </span>
                </p>
                <p><strong>Deadline:</strong> {{ optional($task->deadline)->format('Y-m-d') ?? '—' }}</p>
                <p><strong>Description:</strong></p>
                <p class="muted">{{ $task->description ?? 'No description provided.' }}</p>
            </div>

            <aside class="task-actions">
                <div class="card">
                    <h4>Status</h4>
                    <p class="pill" style="display: inline-block; padding: 8px 16px; border-radius: 999px; background-color: #ede9fe; color: #7008e7; font-weight: 600;">
                        <span class="status-badge {{ $task->status }}">
                            {{ strtoupper(str_replace('-', ' ', $task->status)) }}
                        </span>
                    </p>

                    @if($task->assigned_to == auth()->id())
                        <div style="margin-top: 16px;">
                            <form method="POST" action="{{ route('staff.tasks.update', $task->id) }}">
                                @csrf
                                @if($task->status == 'pending')
                                    <input type="hidden" name="status" value="in-progress">
                                    <button class="btn-primary" type="submit" style="width: 100%;">Start Task</button>
                                @elseif($task->status == 'in-progress')
                                    <input type="hidden" name="status" value="completed">
                                    <button class="btn-primary" type="submit" style="width: 100%;">Mark Complete</button>
                                @endif
                            </form>
                        </div>
                    @endif

                    <hr style="margin: 16px 0; border: none; border-top: 1px solid #e5e7eb;">

                    <a href="{{ route('staff.issues.create', ['task_id' => $task->id, 'back_url' => route('staff.tasks.show', $task->id)]) }}" class="btn-secondary" style="display: block; width: 100%; text-align: center; padding: 12px; border-radius: 14px; background-color: #f3f4f6; color: #4a5565; text-decoration: none; font-weight: 600; transition: all 0.2s;">Report Issue</a>
                </div>
            </aside>
        </div>
    </div>
@endsection
