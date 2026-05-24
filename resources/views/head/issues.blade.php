@extends('head.layout.app')

@section('page-title', 'Issues')
@section('page-subtitle', 'Track and manage reported issues.')

@section('content')
    <div class="card page-card">
        <div class="card-header">
            <h2>Issues</h2>
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
                            <td>
                                <span class="status-badge {{ $issue->status }}">{{ strtoupper(str_replace('-', ' ', $issue->status)) }}</span>
                            </td>
                            <td>{{ $issue->reporter?->name ?? '-' }}</td>
                            <td>{{ $issue->created_at?->format('M d, Y') }}</td>
                            <td class="table-actions">
                                @if ($issue->status !== 'resolved')
                                    <button type="button" class="text-link" data-modal-open="issue-modal" data-modal-action="{{ route('head.issues.update', $issue) }}" data-modal-method="PUT" data-status="{{ $issue->status }}">Edit</button>
                                @else
                                    <span class="muted">Resolved</span>
                                @endif
                                <form method="POST" action="{{ route('head.issues.destroy', $issue) }}">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" data-confirm="Delete this issue?" class="text-danger">Delete</button>
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