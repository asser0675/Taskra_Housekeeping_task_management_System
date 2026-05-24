@extends('staff.layout.app')

@section('page-title', 'Report an Issue')
@section('page-subtitle', 'Describe any problems encountered')

@section('content')
    <div class="card page-card">
        <div class="card-header">
            <h2>Report an Issue</h2>
            <a href="{{ $backUrl ?? route('staff.tasks') }}" class="text-link">Back</a>
        </div>

        <form method="POST" action="{{ route('staff.issues.store') }}" style="display: flex; flex-direction: column; gap: 16px;">
            @csrf

            <div class="form-group">
                <label for="task_id" class="input-label">Task</label>

                @if (!empty($selectedTask))
                    <input type="hidden" name="task_id" value="{{ $selectedTask->id }}">
                    <div class="form-input" style="height: 48px; display:flex; align-items:center;">
                        {{ $selectedTask->task_type }} - Room {{ $selectedTask->room?->room_number ?? '-' }}
                    </div>
                @else
                    <select name="task_id" id="task_id" class="form-input" style="height: 48px;" required>
                        <option value="">Select a task</option>
                        @foreach ($tasks as $task)
                            <option value="{{ $task->id }}" {{ (string)request('task_id') === (string)$task->id ? 'selected' : '' }}>{{ $task->task_type }} - Room {{ $task->room?->room_number ?? '-' }}</option>
                        @endforeach
                    </select>
                @endif
            </div>

            <div class="form-group">
                <label for="description" class="input-label">Description</label>
                <textarea name="description" id="description" class="form-input" style="height: auto; min-height: 120px; padding: 12px 14px; resize: vertical;" placeholder="Describe the issue in detail..." required></textarea>
            </div>

            <div style="display: flex; gap: 12px; margin-top: 8px;">
                <button type="submit" data-confirm="Submit this issue?" class="btn-primary" style="width: auto; flex: 1;">Submit Issue</button>
                <a href="{{ $backUrl ?? route('staff.tasks') }}" class="btn-outline" style="width: auto; flex: 1; display: inline-flex; align-items: center; justify-content: center; text-decoration: none;">Cancel</a>
            </div>
        </form>
    </div>
@endsection