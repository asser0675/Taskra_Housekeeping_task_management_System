@extends('head.layout.app')

@section('page-title', 'Reports')
@section('page-subtitle', 'View operational reports and statistics.')

@section('content')
    <div class="stats-grid">
        <div class="stat-card">
            <p>Total Tasks</p>
            <h2>{{ $stats['totalTasks'] ?? 0 }}</h2>
        </div>

        <div class="stat-card">
            <p>Completed Tasks</p>
            <h2>{{ $stats['completed'] ?? 0 }}</h2>
        </div>

        <div class="stat-card">
            <p>Open Issues</p>
            <h2>{{ $stats['openIssues'] ?? 0 }}</h2>
        </div>
    </div>

    <div class="card page-card" style="margin-top: 20px;">
        <h2>Summary</h2>
        <div style="display:flex; flex-direction:column; gap:12px; margin-top:12px;">
            <div style="display:flex; justify-content:space-between; padding:12px; background:#f6f4fb; border-radius:8px;">
                <span>Total Tasks</span>
                <strong>{{ $stats['totalTasks'] ?? 0 }}</strong>
            </div>
            <div style="display:flex; justify-content:space-between; padding:12px; background:#f6f4fb; border-radius:8px;">
                <span>Completed</span>
                <strong>{{ $stats['completed'] ?? 0 }}</strong>
            </div>
            <div style="display:flex; justify-content:space-between; padding:12px; background:#f6f4fb; border-radius:8px;">
                <span>Open Issues</span>
                <strong>{{ $stats['openIssues'] ?? 0 }}</strong>
            </div>
        </div>
    </div>
@endsection