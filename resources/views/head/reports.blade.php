@extends('head.layout.app')

@section('page-title', 'Reports')
@section('page-subtitle', 'View operational reports and statistics.')

@section('content')
    <div class="stats-grid">
        <div class="stat-card stat-purple">
            <div class="stat-left">
                <div class="stat-icon"><svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="3" width="18" height="18" rx="2" /><path d="M8 7h8" /><path d="M8 11h8" /></svg></div>
                <div><div class="stat-label">Total Tasks</div></div>
            </div>
            <div class="stat-value"><strong>{{ $stats['totalTasks'] ?? 0 }}</strong></div>
        </div>

        <div class="stat-card stat-green">
            <div class="stat-left">
                <div class="stat-icon"><svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><path d="M20 6L9 17l-5-5"/></svg></div>
                <div><div class="stat-label">Completed Tasks</div></div>
            </div>
            <div class="stat-value"><strong>{{ $stats['completed'] ?? 0 }}</strong></div>
        </div>

        <div class="stat-card stat-orange">
            <div class="stat-left">
                <div class="stat-icon"><svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><path d="M10.29 3.86L1.82 18a2 2 0 001.71 3h16.94a2 2 0 001.71-3L13.71 3.86a2 2 0 00-3.42 0z"/><path d="M12 9v4"/><path d="M12 17h.01"/></svg></div>
                <div><div class="stat-label">Open Issues</div></div>
            </div>
            <div class="stat-value"><strong>{{ $stats['openIssues'] ?? 0 }}</strong></div>
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