<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
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
    </style>
</head>
<meta name="csrf-token" content="{{ csrf_token() }}">

<body class="flex h-screen bg-main-bg font-mono">
    <!-- Sidebar -->

    @include('admin.sidebar')

    <!-- Main Content Area -->
    <div class="flex-1 flex flex-col">
        <!-- Top Navbar -->
        <header class="bg-secondary-bg text-text-white p-4 shadow-md flex justify-between items-center">
            <h1 class="text-2xl font-bold">Welcome, Admin</h1>
            <div>
                <span class="text-sm">Logged in as: {{ Auth::user()->name }}</span>
            </div>
        </header>



        <div class="flex-1 p-6 overflow-auto">
            @yield('content')
        </div>


        <!-- Footer -->
        <footer class="bg-secondary-bg text-text-white p-4 text-center">
            <p>&copy; 2024 Gas By Gas. All rights reserved.</p>
        </footer>
    </div>
</body>

</html>