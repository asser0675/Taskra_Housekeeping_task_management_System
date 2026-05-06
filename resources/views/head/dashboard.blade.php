@extends('head.layout.app')

@section('page-title', 'Dashboard')
@section('page-subtitle', 'Welcome back! Here\'s what\'s happening today.')

@section('content')
    <!-- STATS -->
    <div class="stats-grid">
        <div class="stat-card">
            <p>Total Tasks</p>
            <h2>{{ $totalTasks }}</h2>
        </div>

        <div class="stat-card">
            <p>Completed</p>
            <h2>{{ $completed }}</h2>
        </div>

        <div class="stat-card">
            <p>Pending</p>
            <h2>{{ $pending }}</h2>
        </div>

        <div class="stat-card">
            <p>In Progress</p>
            <h2>{{ $inProgress }}</h2>
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