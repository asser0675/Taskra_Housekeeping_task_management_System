<div class="admin-modal" id="room-modal">
    <div class="admin-modal-card">
        <div class="admin-modal-header">
            <h3>Room Form</h3>
            <button type="button" class="admin-modal-close" data-modal-close>&times;</button>
        </div>

        <form method="POST" action="{{ route('admin.rooms.store') }}" class="admin-modal-form" data-modal-form data-default-action="{{ route('admin.rooms.store') }}">
            @csrf
            <input type="hidden" name="_method" value="">

            <label class="form-group">
                <span>Room Number</span>
                <input type="text" name="room_number" class="form-input" placeholder="301">
            </label>

            <label class="form-group">
                <span>Status</span>
                <select name="status" class="form-input">
                    <option value="Ready">Ready</option>
                    <option value="Dirty">Dirty</option>
                    <option value="In Progress">In Progress</option>
                    <option value="For Maintenance">For Maintenance</option>
                </select>
            </label>

            <div class="modal-actions">
                <button type="button" class="btn-secondary" data-modal-close>Cancel</button>
                <button type="submit" data-confirm="Save changes to this room?" class="btn-primary">Save Room</button>
            </div>
        </form>
    </div>
</div>