<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @vite('resources/css/app.css')
</head>
<body>

<div class="login-container">

    <div class="login-card">

        <div class="login-header">
            <div class="login-title">Welcome Back</div>
            <div class="login-subtitle">Login to your account</div>
        </div>

        @if ($errors->any())
            <div style="color:red; text-align:center;">
                {{ $errors->first() }}
            </div>
        @endif

        <form method="POST" action="{{ route('login') }}" class="login-form">
            @csrf

            <!-- Email -->
            <div class="input-group">
                <label class="input-label">Email</label>
                <div class="input-wrapper">
                    <input type="email" name="email"
                           value="{{ old('email') }}"
                           class="form-input"
                           placeholder="Enter your email" required>
                </div>
            </div>

            <!-- Password -->
            <div class="input-group">
                <label class="input-label">Password</label>
                <div class="input-wrapper">
                    <input type="password" name="password"
                           class="form-input"
                           placeholder="Enter your password" required>
                </div>
            </div>

            <!-- Options -->
            <div class="form-options">
                <label class="remember-me">
                    <input type="checkbox" name="remember" class="checkbox-input">
                    <span class="checkbox-label">Remember me</span>
                </label>

                <a href="{{ route('password.request') }}" class="forgot-password">
                    Forgot password?
                </a>
            </div>

            <!-- Button -->
            <button type="submit" class="submit-button">
                Sign In
            </button>

        </form>

    </div>

</div>

</body>
</html>