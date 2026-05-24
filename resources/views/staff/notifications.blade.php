<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Notifications</title>
    @vite(['resources/css/admin.css', 'resources/js/app.js'])
</head>
<body class="admin-body">
    <div class="admin-main" style="max-width: 1100px; margin: 0 auto;">
        <div class="card page-card">
            <div class="card-header">
                <h2>Notifications</h2>
                <a href="{{ route('staff.dashboard') }}" class="text-link">Back to Dashboard</a>
            </div>

            <div class="reports-grid">
                <div class="card">
                    <h2>Recent Tasks</h2>
                    <div class="stack-list">
                        @forelse ($tasks as $task)
                            <div class="stack-item">
                                <strong>{{ $task->task_type }}</strong>
                                <span>
                                    Room {{ $task->room?->room_number ?? '-' }} | 
                                    <span class="status-badge {{ $task->status }}">
                                        {{ strtoupper(str_replace('-', ' ', $task->status)) }}
                                    </span>
                                </span>
                            </div>
                        @empty
                            <p>No assigned tasks yet.</p>
                        @endforelse
                    </div>
                </div>

                <div class="card">
                    <h2>Reported Issues</h2>
                    <div class="stack-list">
                        @forelse ($issues as $issue)
                            <div class="stack-item">
                                <strong>{{ $issue->task?->task_type ?? 'Issue' }}</strong>
                                <span>
                                    <span class="status-badge {{ $issue->status }}">
                                        {{ strtoupper(str_replace('-', ' ', $issue->status)) }}
                                    </span> | {{ $issue->description }}
                                </span>
                            </div>
                        @empty
                            <p>No reported issues yet.</p>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>