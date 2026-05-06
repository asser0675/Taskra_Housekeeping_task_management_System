@extends('admin.layouts.app')
@section('page-title', 'Issues')
@section('page-subtitle', 'Track maintenance issues against tasks and route them through resolution.')

@section('content')
    <div class="card page-card">
        <div class="card-header">
            <h2>Issue Log</h2>
            <button type="button" class="btn-primary" data-modal-open="issue-modal">Add Issue</button>
        </div>

        <div class="table-wrap">
            <table class="data-table">
                <thead>
                    <tr>
                        <th>Task</th>
                        <th>Room</th>
                        <th>Reporter</th>
                        <th>Status</th>
                        <th>Description</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($issues as $issue)
                        <tr>
                            <td>{{ $issue->task?->task_type ?? '-' }}</td>
                            <td>{{ $issue->task?->room?->room_number ?? '-' }}</td>
                            <td>{{ $issue->reporter?->name ?? '-' }}</td>
                            <td>{{ $issue->status }}</td>
                            <td>{{ $issue->description }}</td>
                            <td class="table-actions">
                                <button type="button" class="text-link" data-modal-open="issue-modal" data-modal-action="{{ route('admin.issues.update', $issue) }}" data-modal-method="PUT" data-task-id="{{ $issue->task_id }}" data-reported-by="{{ $issue->reported_by }}" data-description="{{ e($issue->description) }}" data-status="{{ $issue->status }}">Edit</button>
                                <form method="POST" action="{{ route('admin.issues.destroy', $issue) }}" onsubmit="return confirm('Delete this issue?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-danger">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="6">No issues found.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{ $issues->onEachSide(1)->links('pagination::tailwind') }}
    </div>

    @include('admin.modals.issue')
@endsection