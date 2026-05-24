@extends('admin.layouts.app')

@section('page-title', 'Teams')
@section('page-subtitle', 'Create and maintain the user accounts.')

@section('content')
    <div class="card page-card">
        <div class="card-header">
            <h2>Team Members</h2>
            <button type="button" class="btn-primary" data-modal-open="member-modal">Add Member</button>
        </div>

        <div class="table-wrap">
            <table class="data-table">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Role</th>
                        <th>Created</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($teamMembers as $member)
                        <tr>
                            <td>{{ $member->name }}</td>
                            <td>{{ $member->email }}</td>
                            <td>{{ $member->role }}</td>
                            <td>{{ $member->created_at?->format('M d, Y') }}</td>
                            <td class="table-actions">
                                <button type="button" class="text-link" data-modal-open="member-modal" data-modal-action="{{ route('admin.teams.update', $member) }}" data-modal-method="PUT" data-name="{{ $member->name }}" data-email="{{ $member->email }}" data-role="{{ $member->role }}">Edit</button>
                                    <form method="POST" action="{{ route('admin.teams.destroy', $member) }}">
                                    @csrf
                                    @method('DELETE')
                                        <button type="submit" data-confirm="Delete this team member?" class="text-danger">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="5">No team members found.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{ $teamMembers->onEachSide(1)->links('pagination::custom') }}
    </div>

    @include('admin.modals.member')
@endsection
