@extends('admin.layouts.app')
@section('page-title', 'Rooms')
@section('page-subtitle', 'Create, update, and remove rooms.')

@section('content')
    <div class="card page-card">
        <div class="card-header">
            <h2>Room Registry</h2>
            <button type="button" class="btn-primary" data-modal-open="room-modal">Add Room</button>
        </div>

        <div class="table-wrap">
            <table class="data-table">
                <thead>
                    <tr>
                        <th>Room Number</th>
                        <th>Status</th>
                        <th>Created</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($rooms as $room)
                        <tr>
                            <td>{{ $room->room_number }}</td>
                            <td>{{ $room->status }}</td>
                            <td>{{ $room->created_at?->format('M d, Y') }}</td>
                            <td class="table-actions">
                                <button type="button" class="text-link" data-modal-open="room-modal" data-modal-action="{{ route('admin.rooms.update', $room) }}" data-modal-method="PUT" data-room-number="{{ $room->room_number }}" data-status="{{ $room->status }}">Edit</button>
                                <form method="POST" action="{{ route('admin.rooms.destroy', $room) }}" onsubmit="return confirm('Delete this room?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-danger">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="4">No rooms found.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{ $rooms->onEachSide(1)->links('pagination::custom') }}
    </div>

    @include('admin.modals.room')
@endsection