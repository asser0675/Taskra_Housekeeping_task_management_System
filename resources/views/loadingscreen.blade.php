<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Loading Screen</title>

    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="min-h-screen bg-[#f6f4fb] flex items-center justify-center p-4">

<div class="w-full max-w-md text-center">

    <!-- Logo -->
    <div class="mb-10 sm:mb-12">
        <h1 class="font-bold text-[#101828] text-2xl sm:text-3xl tracking-tight mb-2">
            Taskra
        </h1>
    </div>

    <!-- Loading Card -->
    <div class="bg-white rounded-[24px] shadow-[0px_1px_3px_0px_rgba(0,0,0,0.1),0px_1px_2px_0px_rgba(0,0,0,0.1)] p-6 sm:p-8 md:p-12">

        <!-- Animated Icon -->
        <div class="mb-8 flex justify-center">
            <div class="relative">

                <!-- Rotating Ring -->
                <div class="w-20 h-20 sm:w-24 sm:h-24 rounded-full border-4 border-[#ddd6ff] border-t-[#8e51ff] animate-spin"></div>

                <!-- Inner Circle -->
                <div class="absolute inset-0 flex items-center justify-center">
                    <div class="w-14 h-14 sm:w-16 sm:h-16 bg-gradient-to-br from-[#8e51ff] to-[#7f22fe] rounded-full animate-pulse flex items-center justify-center">

                        <svg width="32"
                             height="32"
                             viewBox="0 0 20 20"
                             fill="none"
                             class="text-white">

                            <path d="M16.6667 5L7.50004 14.1667L3.33337 10"
                                  stroke="currentColor"
                                  stroke-width="2"
                                  stroke-linecap="round"
                                  stroke-linejoin="round"/>
                        </svg>

                    </div>
                </div>

            </div>
        </div>

        <!-- Text -->
        <h2 class="font-bold text-[#101828] text-lg sm:text-xl mb-2">
            Logging you in
        </h2>

        <p class="text-[#6a7282] text-sm mb-6">
            Please wait while we set up your workspace...
        </p>

        <!-- Progress Bar -->
        <div class="w-full bg-[#f3f4f6] rounded-full h-2 overflow-hidden">
            <div id="progressBar"
                 class="h-full bg-gradient-to-r from-[#8e51ff] to-[#ff8904] rounded-full transition-all duration-300 ease-out"
                 style="width: 0%">
            </div>
        </div>

        <!-- Percentage -->
        <p id="progressText"
           class="mt-4 font-semibold text-[#8e51ff] text-sm">
            0%
        </p>

    </div>

    <!-- Loading Message -->
    <div class="mt-6">
        <p id="loadingMessage"
           class="text-[#6a7282] text-xs sm:text-sm">
            Authenticating credentials...
        </p>
    </div>

</div>

<script>
    let progress = 0;
    let dashboardUrl = '/dashboard';

    const progressBar = document.getElementById('progressBar');
    const progressText = document.getElementById('progressText');
    const loadingMessage = document.getElementById('loadingMessage');

    // Fetch the role-based dashboard URL
    fetch('/api/dashboard-url', {
        method: 'GET',
        headers: {
            'Content-Type': 'application/json',
            'Accept': 'application/json',
        },
        credentials: 'same-origin'
    })
    .then(response => {
        if (!response.ok) {
            throw new Error('Failed to fetch dashboard URL');
        }
        return response.json();
    })
    .then(data => {
        dashboardUrl = data.url;
    })
    .catch(error => {
        console.error('Error fetching dashboard URL:', error);
        dashboardUrl = '/dashboard';
    });

    const interval = setInterval(() => {

        progress += 10;

        progressBar.style.width = progress + '%';
        progressText.innerText = progress + '%';

        // Dynamic messages
        if (progress < 30) {
            loadingMessage.innerText = 'Authenticating credentials...';
        } 
        else if (progress < 60) {
            loadingMessage.innerText = 'Loading your tasks...';
        } 
        else if (progress < 90) {
            loadingMessage.innerText = 'Preparing your dashboard...';
        } 
        else {
            loadingMessage.innerText = 'Almost there...';
        }

        // Redirect when complete
        if (progress >= 100) {
            clearInterval(interval);

            setTimeout(() => {
                window.location.href = dashboardUrl;
            }, 300);
        }

    }, 200);
</script>

</body>
</html>