@extends('admin.layouts.app')
@section('page-title', 'Issues')
@section('page-subtitle', 'Track maintenance issues.')

@section('content')
    <div class="card page-card">
        <div class="card-header">
            <h2>Issue Log</h2>
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
                            <td>
                                <span class="status-badge {{ $issue->status }}">{{ strtoupper(str_replace('-', ' ', $issue->status)) }}</span>
                            </td>
                            <td>{{ $issue->description }}</td>
                            <td class="table-actions">
                                @if ($issue->status !== 'resolved')
                                    <button type="button" class="text-link" data-modal-open="issue-modal" data-modal-action="{{ route('admin.issues.update', $issue) }}" data-modal-method="PUT" data-status="{{ $issue->status }}">Edit</button>
                                @else
                                    <span class="muted">Resolved</span>
                                @endif
                                <form method="POST" action="{{ route('admin.issues.destroy', $issue) }}">
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

    @include('admin.modals.issue')
@endsection