<!DOCTYPE html>
<html>
<head>
    @vite('resources/css/app.css')
</head>
<body>

<div class="dashboard-container">

    <!-- Sidebar -->
    @include('staff.partials.sidebar')

    <!-- Main Content -->
    <main class="main-content">

        <!-- Welcome -->
        <div class="welcome-banner">
            <h2 class="welcome-title">
                Hello, {{ auth()->user()->name }}
            </h2>
        </div>

        <!-- Header -->
        <div class="dashboard-header">
            <h1 class="page-title">Dashboard</h1>
            <p class="page-subtitle">{{ now()->format('l, d F Y') }}</p>
        </div>

        <!-- Stats -->
        <div class="stats-grid">
            <div class="stat-card blue">
                <div class="stat-label">TOTAL ASSIGNED</div>
                <div class="stat-value">{{ $stats['total'] ?? 0 }}</div>
            </div>

            <div class="stat-card orange">
                <div class="stat-label">PENDING</div>
                <div class="stat-value">
                    {{ $stats['pending'] ?? 0 }}
                </div>
            </div>

            <div class="stat-card purple">
                <div class="stat-label">IN PROGRESS</div>
                <div class="stat-value">
                    {{ $stats['inProgress'] ?? 0 }}
                </div>
            </div>

            <div class="stat-card green">
                <div class="stat-label">COMPLETED</div>
                <div class="stat-value">
                    {{ $stats['completed'] ?? 0 }}
                </div>
            </div>
        </div>

        <!-- Task Table -->
        <div class="task-list-container">
            <div class="task-list-header">
                <h3 class="section-title">My Tasks List</h3>
            </div>

            <div class="table-container">
                <table class="task-table">
                    <thead>
                        <tr>
                            <th>Task</th>
                            <th>Room</th>
                            <th>Status</th>
                            <th>Priority</th>
                            <th>Action</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse($tasks as $task)
                        <tr>
                            <td class="task-title">{{ $task->task_type }}</td>
                            <td class="task-room">{{ $task->room->room_number ?? '' }}</td>

                            <td>
                                <span class="status-badge {{ $task->status }}">
                                    {{ strtoupper(str_replace('-', ' ', $task->status)) }}
                                </span>
                            </td>

                            <td>
                                <span class="status-badge {{ $task->priority ?? 'Low' }}">
                                    {{ $task->priority ?? 'N/A' }}
                                </span>
                            </td>

                            <td class="table-actions">
                                @if($task->status == 'pending')
                                    <form method="POST" action="{{ route('staff.tasks.update', $task->id) }}" style="display: inline;">
                                        @csrf
                                        <input type="hidden" name="status" value="in-progress">
                                        <button class="action-btn start">Start</button>
                                    </form>

                                @elseif($task->status == 'in-progress')
                                    <form method="POST" action="{{ route('staff.tasks.update', $task->id) }}" style="display: inline;">
                                        @csrf
                                        <input type="hidden" name="status" value="completed">
                                        <button class="action-btn finish">Finish</button>
                                    </form>

                                @else
                                    <span class="task-done">Done</span>
                                @endif
                                <a href="{{ route('staff.tasks.show', $task->id) }}" class="action-btn" style="display: inline-block; background-color: #f0f1f9; border-color: #e5e7eb; color: #4a5565; margin-left: 4px;">View</a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" style="text-align:center; padding:40px 20px; color:#6a7282;">
                                No tasks assigned yet.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>

                </table>
            </div>

            <!-- Pagination -->
            <div style="margin-top: 20px; display: flex; justify-content: center;">
                {{ $tasks->onEachSide(1)->links('pagination::tailwind') }}
            </div>
        </div>

    </main>

</div>

</body>
</html>