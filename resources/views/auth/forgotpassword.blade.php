<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GAS BY GAS FORGOT PASSWORD</title>
    @vite('resources/css/app.css')
    <style>
        /* Background Gradient Animation */
        body {
            background: linear-gradient(135deg, #031716, #032F30, #0A7075);
            background-size: 400% 400%;
            animation: gradientBackground 10s ease infinite;
        }

        @keyframes gradientBackground {
            0% {
                background-position: 0% 50%;
            }

            50% {
                background-position: 100% 50%;
            }

            100% {
                background-position: 0% 50%;
            }
        }

        /* Logo and Form Slide-in Animation */
        .animated-logo,
        .animated-form {
            opacity: 0;
            transform: translateY(-20px);
            animation: slideDown 1s ease forwards;
        }

        /* Delay for form fields */
        .animated-form {
            animation-delay: 0.3s;
        }

        @keyframes slideDown {
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
    </style>
</head>

<body class="flex items-center justify-center min-h-screen bg-main-bg font-mono">
    <!-- Login Container -->
    <div
        class="w-full max-w-md p-8 space-y-6 bg-secondary-bg rounded-lg shadow-md transform transition-transform duration-300 ease-in-out hover:scale-105">
        <!-- Branding / Logo -->
        <div class="text-center animated-logo">
            <h2 class="text-3xl font-bold text-text-primary">Gas By Gas</h2>
            <p class="text-text-secondary">Forgot Password</p>
        </div>
        @if (session('status'))
            <div class="alert alert-success">{{ session('status') }}</div>
        @endif

        <!-- Login Form -->
        <form class="space-y-4 animated-form" action="{{ route('password.email') }}" method="POST">
            @csrf
            <!-- Email Input -->
            <div>
                <label for="email" class="block text-sm font-medium text-text-secondary">Email Address</label>
                <input type="email" id="email" name="email" required value="{{ old('email') }}"
                    class="w-full px-4 py-2 mt-1 border rounded-lg focus:outline-none focus:ring-2 focus:ring-accent-1 focus:border-transparent border-accent-2 text-text-white bg-main-bg"
                    placeholder="admin@gmail.com">
                @error('email')
                    <!-- Display error message for email field -->
                    <span class="text-sm text-red-500">{{ $message }}</span>
                @enderror
            </div>


            <!-- Login Button -->
            <div>
                <button type="submit"
                    class="w-full px-4 py-2 font-semibold text-white bg-accent-1 rounded-lg hover:bg-accent-2 focus:outline-none focus:bg-accent-2 transition duration-200">
                    Reset Password
                </button>
            </div>


        </form>


        <!-- Forgot Password Link -->
        <div class="text-center">
            <a href="/login-view" class="text-sm text-accent-1 hover:underline">Remember your password? Log In</a>
        </div>
    </div>
</body>

</html>
