<div class="dashboard-header">
    <div>
        <h1 class="page-title">@yield('page-title', 'Dashboard')</h1>
        <p class="page-subtitle">@yield('page-subtitle', 'Manage your tasks.')</p>
    </div>

    <div class="user-section">
        <span>{{ auth()->user()->name }}</span>
        <small style="display: block; font-size: 12px; color: #666;">{{ strtoupper(auth()->user()->role) }}</small>
    </div>
</div>
