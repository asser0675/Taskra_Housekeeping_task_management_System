@extends('admin.layouts.app')

@section('page-title', 'Dashboard')
@section('page-subtitle', 'Overview and management controls for hotel operations.')

@section('content')
    <!-- Stats Grid -->
    <section class="stats-grid">
        <article class="stat-card">
            <p>Total Tasks</p>
            <strong>{{ $stats['totalTasks'] ?? 0 }}</strong>
        </article>
        <article class="stat-card">
            <p>Completed</p>
            <strong>{{ $stats['completedTasks'] ?? 0 }}</strong>
        </article>
        <article class="stat-card">
            <p>Pending</p>
            <strong>{{ $stats['pendingTasks'] ?? 0 }}</strong>
        </article>
        <article class="stat-card">
            <p>In Progress</p>
            <strong>{{ $stats['inProgressTasks'] ?? 0 }}</strong>
        </article>
    </section>

    <!-- Recent Items Grid -->
    <section class="dashboard-grid">
        <div class="dashboard-column">
            <!-- Recent Tasks -->
            <div class="card">
                <div class="card-header">
                    <h2>Recent Tasks</h2>
                    <a href="{{ route('admin.tasks') }}" class="link-text">View All</a>
                </div>
                <div class="stack-list">
                    @forelse ($tasks as $task)
                        <div class="stack-item">
                            <div>
                                <strong>{{ $task->task_type }}</strong>
                                <p style="font-size: 12px; color: #666;">Room {{ $task->room?->room_number ?? 'N/A' }} • {{ $task->assigned_to ?? 'Unassigned' }}</p>
                            </div>
                            <span class="pill-status">{{ $task->status }}</span>
                        </div>
                    @empty
                        <p style="color: #999;">No tasks found.</p>
                    @endforelse
                </div>
            </div>

            <!-- Recent Rooms -->
            <div class="card">
                <div class="card-header">
                    <h2>Recent Rooms</h2>
                    <a href="{{ route('admin.rooms') }}" class="link-text">View All</a>
                </div>
                <div class="stack-list">
                    @forelse ($rooms as $room)
                        <div class="stack-item">
                            <strong>Room {{ $room->room_number }}</strong>
                            <span>{{ $room->status }}</span>
                        </div>
                    @empty
                        <p style="color: #999;">No rooms available.</p>
                    @endforelse
                </div>
            </div>
        </div>

        <div class="dashboard-column">
            <!-- Recent Issues -->
            <div class="card">
                <div class="card-header">
                    <h2>Open Issues</h2>
                    <a href="{{ route('admin.issues') }}" class="link-text">View All</a>
                </div>
                <div class="stack-list">
                    @forelse ($issues as $issue)
                        <div class="stack-item">
                            <strong>{{ $issue->task?->task_type ?? 'Issue' }}</strong>
                            <span>{{ $issue->status }}</span>
                        </div>
                    @empty
                        <p style="color: #999;">No issues reported.</p>
                    @endforelse
                </div>
            </div>

            <!-- Team Members -->
            <div class="card">
                <div class="card-header">
                    <h2>Team Members</h2>
                    <a href="{{ route('admin.teams') }}" class="link-text">Manage</a>
                </div>
                <div class="stack-list">
                    @forelse ($teamMembers as $member)
                        <div class="stack-item">
                            <strong>{{ $member->name }}</strong>
                            <span>{{ $member->role }}</span>
                        </div>
                    @empty
                        <p style="color: #999;">No team members.</p>
                    @endforelse
                </div>
            </div>
        </div>
    </section>
@endsection
