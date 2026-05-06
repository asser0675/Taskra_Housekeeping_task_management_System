@extends('admin.layouts.app')
@section('page-title', 'Reports')
@section('page-subtitle', 'Export summary metrics and inspect live activity from the database.')

@section('content')
    <div class="reports-actions card">
        <div>
            <h2>Snapshot</h2>
            <p>Generated from the current task, room, issue, and team records.</p>
        </div>
        <a href="{{ route('admin.reports.export') }}" class="btn-primary">Export CSV</a>
    </div>

    <section class="stats-grid">
        <article class="stat-card stat-purple"><p>Total Tasks</p><strong>{{ $stats['totalTasks'] }}</strong></article>
        <article class="stat-card stat-green"><p>Completed</p><strong>{{ $stats['completedTasks'] }}</strong></article>
        <article class="stat-card stat-orange"><p>Open Issues</p><strong>{{ $stats['openIssues'] }}</strong></article>
        <article class="stat-card stat-blue"><p>Team Members</p><strong>{{ $stats['teamCount'] }}</strong></article>
    </section>

    <div class="reports-grid">
        <div class="card">
            <h2>Recent Tasks</h2>
            <div class="stack-list">
                @forelse ($recentTasks as $task)
                    <div class="stack-item"><strong>{{ $task->task_type }}</strong><span>{{ $task->status }} | {{ $task->priority ?? '-' }}</span></div>
                @empty
                    <p>No tasks yet.</p>
                @endforelse
            </div>
        </div>

        <div class="card">
            <h2>Recent Issues</h2>
            <div class="stack-list">
                @forelse ($recentIssues as $issue)
                    <div class="stack-item"><strong>{{ $issue->task?->task_type ?? 'Issue' }}</strong><span>{{ $issue->status }}</span></div>
                @empty
                    <p>No issues yet.</p>
                @endforelse
            </div>
        </div>
    </div>
@endsection