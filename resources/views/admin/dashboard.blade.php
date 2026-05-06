@extends('admin.layouts.app')

@section('page-title', 'Dashboard')
@section('page-subtitle', 'Overview and management controls for hotel operations.')

@section('content')
    <!-- Stats Grid -->
    <section class="stats-grid">
        <article class="stat-card stat-purple">
            <div class="stat-left">
                <div class="stat-icon"><svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="3" width="18" height="18" rx="2" /><path d="M8 7h8" /><path d="M8 11h8" /></svg></div>
                <div><div class="stat-label">Total Tasks</div></div>
            </div>
            <div class="stat-value"><strong>{{ $stats['totalTasks'] ?? 0 }}</strong></div>
        </article>

        <article class="stat-card stat-green">
            <div class="stat-left">
                <div class="stat-icon"><svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><path d="M20 6L9 17l-5-5"/></svg></div>
                <div><div class="stat-label">Completed</div></div>
            </div>
            <div class="stat-value"><strong>{{ $stats['completedTasks'] ?? 0 }}</strong></div>
        </article>

        <article class="stat-card stat-orange">
            <div class="stat-left">
                <div class="stat-icon"><svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><path d="M10.29 3.86L1.82 18a2 2 0 001.71 3h16.94a2 2 0 001.71-3L13.71 3.86a2 2 0 00-3.42 0z"/><path d="M12 9v4"/><path d="M12 17h.01"/></svg></div>
                <div><div class="stat-label">Pending</div></div>
            </div>
            <div class="stat-value"><strong>{{ $stats['pendingTasks'] ?? 0 }}</strong></div>
        </article>

        <article class="stat-card stat-blue">
            <div class="stat-left">
                <div class="stat-icon"><svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><path d="M3 7h18"/><path d="M3 12h18"/><path d="M3 17h18"/></svg></div>
                <div><div class="stat-label">In Progress</div></div>
            </div>
            <div class="stat-value"><strong>{{ $stats['inProgressTasks'] ?? 0 }}</strong></div>
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
