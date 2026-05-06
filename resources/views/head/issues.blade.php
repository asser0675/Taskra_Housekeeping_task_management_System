@extends('head.layout.app')

@section('page-title', 'Issues')
@section('page-subtitle', 'Track and manage reported issues.')

@section('content')
    <div class="card page-card">
        <div class="card-header">
            <h2>Issues</h2>
            <button type="button" class="btn-primary" data-modal-open="issue-modal">Report Issue</button>
        </div>

        <div class="table-wrap">
            <table class="data-table">
                <thead>
                    <tr>
                        <th>Description</th>
                        <th>Task</th>
                        <th>Status</th>
                        <th>Reporter</th>
                        <th>Created</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($issues as $issue)
                        <tr>
                            <td>{{ $issue->description }}</td>
                            <td>{{ $issue->task?->task_type ?? '-' }}</td>
                            <td>{{ ucfirst($issue->status) }}</td>
                            <td>{{ $issue->reporter?->name ?? '-' }}</td>
                            <td>{{ $issue->created_at?->format('M d, Y') }}</td>
                            <td class="table-actions">
                                <button type="button" class="text-link" data-modal-open="issue-modal" data-modal-action="{{ route('head.issues.update', $issue) }}" data-modal-method="PUT" data-task-id="{{ $issue->task_id }}" data-description="{{ $issue->description }}" data-status="{{ $issue->status }}">Edit</button>
                                <form method="POST" action="{{ route('head.issues.destroy', $issue) }}" onsubmit="return confirm('Delete this issue?')">
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

        {{ $issues->onEachSide(1)->links('pagination::custom') }}
    </div>

    @include('head.modals.issue')
@endsection