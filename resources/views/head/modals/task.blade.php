<div class="admin-modal" id="task-modal">
    <div class="admin-modal-card admin-modal-large">
        <div class="admin-modal-header">
            <h3>Task Form</h3>
            <button type="button" class="admin-modal-close" data-modal-close>&times;</button>
        </div>

        <form method="POST" action="{{ route('head.tasks.store') }}" class="admin-modal-form" data-modal-form data-default-action="{{ route('head.tasks.store') }}">
            @csrf
            <input type="hidden" name="_method" value="">

            <label class="form-group">
                <span>Room</span>
                <select name="room_id" class="form-input">
                    @foreach ($rooms as $room)
                        <option value="{{ $room->id }}">Room {{ $room->room_number }}</option>
                    @endforeach
                </select>
            </label>

            <label class="form-group">
                <span>Assign To</span>
                <select name="assigned_to" class="form-input">
                    @foreach ($staff as $housekeeper)
                        <option value="{{ $housekeeper->id }}">{{ $housekeeper->name }}</option>
                    @endforeach
                </select>
            </label>

            <label class="form-group">
                <span>Task Type</span>
                <input type="text" name="task_type" class="form-input" placeholder="Daily Cleaning">
            </label>

            <label class="form-group">
                <span>Status</span>
                <select name="status" class="form-input">
                    <option value="pending">Pending</option>
                    <option value="in-progress">In Progress</option>
                    <option value="completed">Completed</option>
                </select>
            </label>

            <label class="form-group">
                <span>Priority</span>
                <select name="priority" class="form-input">
                    <option value="Low">Low</option>
                    <option value="Medium">Medium</option>
                    <option value="High">High</option>
                </select>
            </label>

            <label class="form-group">
                <span>Deadline</span>
                <input type="date" name="deadline" class="form-input">
            </label>

            <div class="modal-actions">
                <button type="button" class="btn-secondary" data-modal-close>Cancel</button>
                <button type="submit" class="btn-primary">Save Task</button>
            </div>
        </form>
    </div>
</div>
