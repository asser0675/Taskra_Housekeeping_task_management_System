<button type="button" class="hamburger-toggle" id="hamburger-toggle" aria-label="Toggle navigation" aria-controls="sidebar" aria-expanded="false">
    <span></span>
    <span></span>
    <span></span>
</button>

<div class="sidebar-overlay" id="sidebar-overlay"></div>

<aside class="sidebar" id="sidebar" style="display:flex; flex-direction:column; height:100vh;">
    <div>
        <div class="sidebar-header">
            <h1 class="logo">Taskra</h1>
            <p style="font-size: 12px; color: #666; margin: 4px 0 0 0;">{{ $settings->hotel_name ?? 'Admin' }}</p>
        </div>

        <nav class="navigation">
            <a href="{{ route('admin.dashboard') }}" class="nav-item {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">Dashboard</a>
            <a href="{{ route('admin.rooms') }}" class="nav-item {{ request()->routeIs('admin.rooms') ? 'active' : '' }}">Rooms</a>
            <a href="{{ route('admin.tasks') }}" class="nav-item {{ request()->routeIs('admin.tasks') ? 'active' : '' }}">Tasks</a>
            <a href="{{ route('admin.teams') }}" class="nav-item {{ request()->routeIs('admin.teams') ? 'active' : '' }}">Teams</a>
            <a href="{{ route('admin.issues') }}" class="nav-item {{ request()->routeIs('admin.issues') ? 'active' : '' }}">Issues</a>
            <a href="{{ route('admin.reports') }}" class="nav-item {{ request()->routeIs('admin.reports') ? 'active' : '' }}">Reports</a>
            <a href="{{ route('admin.settings') }}" class="nav-item {{ request()->routeIs('admin.settings') ? 'active' : '' }}">Settings</a>
        </nav>
    </div>

    <div style="margin-top:auto;">
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" data-confirm="Are you sure you want to logout?" class="nav-item logout-link" style="width:100%; text-align:left; background:none; border:none;">
                Logout
            </button>
        </form>
    </div>
</aside>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const hamburger = document.getElementById('hamburger-toggle');
    const sidebar = document.getElementById('sidebar');
    const overlay = document.getElementById('sidebar-overlay');

    function toggleSidebar() {
        sidebar.classList.toggle('open');
        overlay.classList.toggle('open');
        hamburger.classList.toggle('active');
        hamburger.setAttribute('aria-expanded', sidebar.classList.contains('open') ? 'true' : 'false');
    }

    hamburger.addEventListener('click', toggleSidebar);
    overlay.addEventListener('click', function() {
        sidebar.classList.remove('open');
        overlay.classList.remove('open');
        hamburger.classList.remove('active');
        hamburger.setAttribute('aria-expanded', 'false');
    });

    // Close sidebar when a nav item is clicked
    document.querySelectorAll('.nav-item').forEach(item => {
        item.addEventListener('click', function() {
            if (window.innerWidth <= 768) {
                sidebar.classList.remove('open');
                overlay.classList.remove('open');
                hamburger.classList.remove('active');
                hamburger.setAttribute('aria-expanded', 'false');
            }
        });
    });
});
</script>