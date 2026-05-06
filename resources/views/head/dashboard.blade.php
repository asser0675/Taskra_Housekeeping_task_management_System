@extends('head.layout.app')

@section('page-title', 'Dashboard')
@section('page-subtitle', 'Welcome back! Here\'s what\'s happening today.')

@section('content')
    <!-- STATS -->
    <div class="stats-grid">
        <div class="stat-card stat-purple">
            <div class="stat-left">
                <div class="stat-icon"><svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="3" width="18" height="18" rx="2" /><path d="M8 7h8" /><path d="M8 11h8" /></svg></div>
                <div><div class="stat-label">Total Tasks</div></div>
            </div>
            <div class="stat-value"><strong>{{ $totalTasks }}</strong></div>
        </div>

        <div class="stat-card stat-green">
            <div class="stat-left">
                <div class="stat-icon"><svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><path d="M20 6L9 17l-5-5"/></svg></div>
                <div><div class="stat-label">Completed</div></div>
            </div>
            <div class="stat-value"><strong>{{ $completed }}</strong></div>
        </div>

        <div class="stat-card stat-orange">
            <div class="stat-left">
                <div class="stat-icon"><svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><path d="M10.29 3.86L1.82 18a2 2 0 001.71 3h16.94a2 2 0 001.71-3L13.71 3.86a2 2 0 00-3.42 0z"/><path d="M12 9v4"/><path d="M12 17h.01"/></svg></div>
                <div><div class="stat-label">Pending</div></div>
            </div>
            <div class="stat-value"><strong>{{ $pending }}</strong></div>
        </div>

        <div class="stat-card stat-blue">
            <div class="stat-left">
                <div class="stat-icon"><svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><path d="M3 7h18"/><path d="M3 12h18"/><path d="M3 17h18"/></svg></div>
                <div><div class="stat-label">In Progress</div></div>
            </div>
            <div class="stat-value"><strong>{{ $inProgress }}</strong></div>
        </div>
    </div>

    <div class="dashboard-grid">
        <div style="display:flex; flex-direction:column; gap:20px;">
            <div class="card page-card">
                <h3>Task Progress Overview</h3>
                <div style="display:flex; flex-direction:column; gap:8px; margin-top:12px;">
                    <p>Completed: {{ $completed }}</p>
                    <p>Pending: {{ $pending }}</p>
                    <p>In Progress: {{ $inProgress }}</p>
                </div>
            </div>

            <div class="card page-card">
                <h3>Staff Performance</h3>
                <div class="table-wrap">
                    <table class="data-table">
                        <thead>
                            <tr>
                                <th>Staff Member</th>
                                <th>Tasks Completed</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($staff as $user)
                                <tr>
                                    <td>{{ $user->name }}</td>
                                    <td>{{ $user->tasks_completed ?? 0 }}</td>
                                </tr>
                            @empty
                                <tr><td colspan="2">No staff data available.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div style="display:flex; flex-direction:column; gap:20px;">
            <div class="card page-card">
                <h3>Critical Alerts</h3>
                @forelse($issues as $issue)
                    <div style="padding:8px 0; border-bottom:1px solid #eee;">
                        <p style="margin:0; font-size:14px;">{{ $issue->description }}</p>
                        <small style="color:#666;">{{ $issue->task?->task_type ?? '-' }}</small>
                    </div>
                @empty
                    <p>No critical issues.</p>
                @endforelse
            </div>
        </div>
    </div>
@endsection