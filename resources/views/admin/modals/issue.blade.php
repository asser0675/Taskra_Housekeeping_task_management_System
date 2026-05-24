<div class="admin-modal" id="issue-modal">
    <div class="admin-modal-card">
        <div class="admin-modal-header">
            <h3>Update Issue Status</h3>
            <button type="button" class="admin-modal-close" data-modal-close>&times;</button>
        </div>

        <form method="POST" action="" class="admin-modal-form" data-modal-form>
            @csrf
            <input type="hidden" name="_method" value="">

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
                <button type="submit" data-confirm="Update issue status?" class="btn-primary">Save Status</button>
            </div>
        </form>
    </div>
</div>