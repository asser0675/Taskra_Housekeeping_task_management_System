<div class="admin-modal" id="member-modal">
    <div class="admin-modal-card">
        <div class="admin-modal-header">
            <h3>Team Member Form</h3>
            <button type="button" class="admin-modal-close" data-modal-close>&times;</button>
        </div>

        <form method="POST" action="{{ route('admin.teams.store') }}" class="admin-modal-form" data-modal-form data-default-action="{{ route('admin.teams.store') }}">
            @csrf
            <input type="hidden" name="_method" value="">

            <label class="form-group">
                <span>Name</span>
                <input type="text" name="name" class="form-input" placeholder="Jane Doe" value="{{ old('name') }}">
            </label>

            <label class="form-group">
                <span>Email</span>
                <input type="email" name="email" class="form-input" placeholder="jane@hotel.com" value="{{ old('email') }}">
            </label>

            <label class="form-group">
                <span>Role</span>
                <select name="role" class="form-input">
                    <option value="housekeeper" {{ old('role') === 'housekeeper' ? 'selected' : '' }}>Housekeeper</option>
                    <option value="head" {{ old('role') === 'head' ? 'selected' : '' }}>Department Head</option>
                    <option value="admin" {{ old('role') === 'admin' ? 'selected' : '' }}>Admin</option>
                </select>
            </label>

            <label class="form-group">
                <span>Password</span>
                <input type="password" name="password" class="form-input" placeholder="Leave blank on edit">
            </label>

            <div class="modal-actions">
                <button type="button" class="btn-secondary" data-modal-close>Cancel</button>
                <button type="submit" class="btn-primary">Save Member</button>
            </div>
        </form>
    </div>
</div>