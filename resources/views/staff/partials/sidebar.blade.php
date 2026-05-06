<button class="hamburger-toggle" id="hamburger-toggle">
    <span></span>
    <span></span>
    <span></span>
</button>

<div class="sidebar-overlay" id="sidebar-overlay"></div>

<aside class="sidebar" id="sidebar" style="display:flex; flex-direction:column; height:100vh;">
    <div>
        <div class="sidebar-header">
            <h1 class="logo">Taskra</h1>
            <p style="font-size: 12px; color: #666; margin: 4px 0 0 0;">Staff</p>
        </div>

        <nav class="navigation">
            <a href="{{ route('staff.dashboard') }}" class="nav-item {{ request()->routeIs('staff.dashboard') ? 'active' : '' }}">Dashboard</a>
            <a href="{{ route('staff.tasks') }}" class="nav-item {{ request()->routeIs('staff.tasks') ? 'active' : '' }}">My Tasks</a>
        </nav>
    </div>

    <div style="margin-top:auto;">
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <a href="#" onclick="this.closest('form').submit()" class="nav-item logout-link">
                Logout
            </a>
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
    }

    hamburger.addEventListener('click', toggleSidebar);
    overlay.addEventListener('click', function() {
        sidebar.classList.remove('open');
        overlay.classList.remove('open');
        hamburger.classList.remove('active');
    });

    // Close sidebar when a nav item is clicked
    document.querySelectorAll('.nav-item').forEach(item => {
        item.addEventListener('click', function() {
            if (window.innerWidth <= 768) {
                sidebar.classList.remove('open');
                overlay.classList.remove('open');
                hamburger.classList.remove('active');
            }
        });
    });
});
</script>
