@extends('head.layout.app')

@section('page-title', 'Team')
@section('page-subtitle', 'View and manage your housekeeping team members.')

@section('content')
    <div class="card page-card">
        <div class="card-header">
            <h2>Team Members</h2>
        </div>

        <div class="table-wrap">
            <table class="data-table">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Role</th>
                        <th>Created</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($team as $member)
                        <tr>
                            <td>{{ $member->name }}</td>
                            <td>{{ $member->email }}</td>
                            <td>{{ ucfirst($member->role) }}</td>
                            <td>{{ $member->created_at?->format('M d, Y') }}</td>
                        </tr>
                    @empty
                        <tr><td colspan="4">No team members found.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{ $team->onEachSide(1)->links('pagination::custom') }}
    </div>
@endsection