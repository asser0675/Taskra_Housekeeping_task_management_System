@extends('staff.layout.app')

@section('page-title', 'My Issues')
@section('page-subtitle', 'Issues you reported for your assigned tasks.')

@section('content')
    <div class="card page-card">
        <div class="card-header">
            <h2>Reported Issues</h2>
            <a href="{{ route('staff.issues.create', ['back_url' => route('staff.issues')]) }}" class="btn-primary" style="width:auto; text-decoration:none;">Create Issue</a>
        </div>

        <div class="table-wrap">
            <table class="data-table">
                <thead>
                    <tr>
                        <th>Room</th>
                        <th>Task</th>
                        <th>Status</th>
                        <th>Description</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($issues as $issue)
                        <tr>
                            <td>{{ $issue->task?->room?->room_number ?? '-' }}</td>
                            <td>{{ $issue->task?->task_type ?? '-' }}</td>
                            <td>
                                <span class="status-badge {{ $issue->status }}">{{ strtoupper(str_replace('-', ' ', $issue->status)) }}</span>
                            </td>
                            <td>{{ $issue->description }}</td>
                            <td class="table-actions">
                                @if ($issue->status !== 'resolved')
                                    <button type="button"
                                            class="text-link"
                                            data-modal-open="staff-issue-modal"
                                            data-modal-action="{{ route('staff.issues.update', $issue) }}"
                                            data-modal-method="PUT"
                                            data-description="{{ e($issue->description) }}">
                                        Edit
                                    </button>
                                @else
                                    <span class="muted">Resolved</span>
                                @endif

                                <form method="POST" action="{{ route('staff.issues.destroy', $issue) }}" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" data-confirm="Delete this issue?" class="text-danger">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="5">No issues found.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{ $issues->onEachSide(1)->links('pagination::custom') }}
    </div>

    <div class="admin-modal" id="staff-issue-modal">
        <div class="admin-modal-card admin-modal-large">
            <div class="admin-modal-header">
                <h3>Edit Issue Description</h3>
                <button type="button" class="admin-modal-close" data-modal-close>&times;</button>
            </div>

            <form method="POST" action="" class="admin-modal-form" data-modal-form>
                @csrf
                <input type="hidden" name="_method" value="">

                <label class="form-group">
                    <span>Description</span>
                    <textarea name="description" class="form-input form-textarea" rows="4" placeholder="Describe the issue"></textarea>
                </label>

                <div class="modal-actions">
                    <button type="button" class="btn-secondary" data-modal-close>Cancel</button>
                    <button type="submit" data-confirm="Save issue changes?" class="btn-primary">Save Changes</button>
                </div>
            </form>
        </div>
    </div>
@endsection
