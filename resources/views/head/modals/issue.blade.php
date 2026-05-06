<div class="admin-modal" id="issue-modal">
    <div class="admin-modal-card admin-modal-large">
        <div class="admin-modal-header">
            <h3>Issue Form</h3>
            <button type="button" class="admin-modal-close" data-modal-close>&times;</button>
        </div>

        <form method="POST" action="{{ route('head.issues.store') }}" class="admin-modal-form" data-modal-form data-default-action="{{ route('head.issues.store') }}">
            @csrf
            <input type="hidden" name="_method" value="">

            <label class="form-group">
                <span>Task (Optional)</span>
                <select name="task_id" class="form-input">
                    <option value="">Select a task...</option>
                    @foreach ($tasks as $task)
                        <option value="{{ $task->id }}">{{ $task->task_type }} - Room {{ $task->room?->room_number ?? '-' }}</option>
                    @endforeach
                </select>
            </label>

            <label class="form-group">
                <span>Description</span>
                <textarea name="description" class="form-input" placeholder="Describe the issue..." rows="4"></textarea>
            </label>

            <label class="form-group">
                <span>Status</span>
                <select name="status" class="form-input">
                    <option value="open">Open</option>
                    <option value="in-progress">In Progress</option>
                    <option value="resolved">Resolved</option>
                </select>
            </label>

            <div class="modal-actions">
                <button type="button" class="btn-secondary" data-modal-close>Cancel</button>
                <button type="submit" class="btn-primary">Save Issue</button>
            </div>
        </form>
    </div>
</div>
