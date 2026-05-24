@extends('admin.layouts.app')
@section('page-title', 'Reports')
@section('page-subtitle', 'Export summary metrics and inspect.')

@section('content')
    <div>
        <section class="stats-grid">
            <article class="stat-card stat-purple">
                <div class="stat-left">
                    <div class="stat-icon"><svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="3" width="18" height="18" rx="2" /><path d="M8 7h8" /><path d="M8 11h8" /></svg></div>
                    <div><div class="stat-label">Total Tasks</div></div>
                </div>
                <div class="stat-value"><strong>{{ $stats['totalTasks'] }}</strong></div>
            </article>

            <article class="stat-card stat-green">
                <div class="stat-left">
                    <div class="stat-icon"><svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><path d="M20 6L9 17l-5-5"/></svg></div>
                    <div><div class="stat-label">Completed</div></div>
                </div>
                <div class="stat-value"><strong>{{ $stats['completedTasks'] }}</strong></div>
            </article>

            <article class="stat-card stat-orange">
                <div class="stat-left">
                    <div class="stat-icon"><svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><path d="M10.29 3.86L1.82 18a2 2 0 001.71 3h16.94a2 2 0 001.71-3L13.71 3.86a2 2 0 00-3.42 0z"/><path d="M12 9v4"/><path d="M12 17h.01"/></svg></div>
                    <div><div class="stat-label">Open Issues</div></div>
                </div>
                <div class="stat-value"><strong>{{ $stats['openIssues'] }}</strong></div>
            </article>

            <article class="stat-card stat-blue">
                <div class="stat-left">
                    <div class="stat-icon"><svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><path d="M17 21v-2a4 4 0 00-3-3.87"/><path d="M7 21v-2a4 4 0 013-3.87"/><circle cx="12" cy="7" r="4"/></svg></div>
                    <div><div class="stat-label">Team Members</div></div>
                </div>
                <div class="stat-value"><strong>{{ $stats['teamCount'] }}</strong></div>
            </article>
        </section>

        <div style="text-align: right; margin-top: 16px; margin-bottom: 20px;">
            <a href="{{ route('admin.reports.export') }}" class="btn-primary" style="white-space: nowrap;">Export CSV</a>
        </div>
    </div>

    <div class="reports-grid">
        <div class="card reports-card">
            <h2>Recent Tasks</h2>
            <div class="stack-list">
                @forelse ($recentTasks as $task)
                    <div class="stack-item">
                        <div class="stack-item-main">
                            <strong>{{ $task->task_type }}</strong>
                            <p class="stack-item-subtitle">{{ $task->deadline?->format('M d, Y') ?? '-' }}</p>
                        </div>
                        <div class="stack-item-badges">
                            <span class="status-badge {{ $task->status }}">{{ strtoupper(str_replace('-', ' ', $task->status)) }}</span>
                            <span class="status-badge {{ $task->priority ?? 'Low' }}" style="margin-left:8px">{{ $task->priority ?? '-' }}</span>
                        </div>
                    </div>
                @empty
                    <p>No tasks yet.</p>
                @endforelse
            </div>

            @if ($recentTasks->hasPages())
                <div style="margin-top: 18px; display: flex; justify-content: center;">
                    {{ $recentTasks->onEachSide(1)->links('pagination::custom') }}
                </div>
            @endif
        </div>

        <div class="card reports-card">
            <h2>Recent Issues</h2>
            <div class="stack-list">
                @forelse ($recentIssues as $issue)
                    <div class="stack-item">
                        <div class="stack-item-main">
                            <strong>{{ $issue->task?->task_type ?? 'Issue' }}</strong>
                            <p class="stack-item-subtitle">{{ $issue->task?->room?->room_number ?? 'No room' }}</p>
                        </div>
                        <div class="stack-item-badges">
                            <span class="status-badge {{ $issue->status ?? '' }}">{{ $issue->status }}</span>
                        </div>
                    </div>
                @empty
                    <p>No issues yet.</p>
                @endforelse
            </div>

            @if ($recentIssues->hasPages())
                <div style="margin-top: 18px; display: flex; justify-content: center;">
                    {{ $recentIssues->onEachSide(1)->links('pagination::custom') }}
                </div>
            @endif
        </div>
    </div>
@endsection