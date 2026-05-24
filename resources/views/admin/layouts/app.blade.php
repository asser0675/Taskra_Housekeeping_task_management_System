<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $title ?? 'Admin Dashboard' }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body>
    <div class="dashboard-container">
        @include('admin.partials.sidebar')

        <main class="main-content">
            @include('admin.partials.topbar')

            @if (session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            @if (session('error'))
                <div class="alert alert-error">{{ session('error') }}</div>
            @endif
            
            @if ($errors->any())
                <div class="alert alert-error">
                    <ul style="margin:0;padding-left:1.2rem">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            @if (session('housekeepersChanged'))
                <script>
                    localStorage.setItem('housekeepers-changed', Date.now().toString());
                    window.dispatchEvent(new CustomEvent('housekeepers-changed'));
                </script>
            @endif

            @yield('content')
        </main>
    </div>

@include('components.confirm-modal')

</body>
</html>