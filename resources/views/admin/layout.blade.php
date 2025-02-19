<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    @vite('resources/css/app.css')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

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
            <button id="toggleSidebar" class="text-white text-2xl focus:outline-none">
                ☰
            </button>
            <form id="logoutForm" action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="px-4 py-2 rounded text-white transition">
                    <img src="{{ asset('images/logout.png') }}" alt="Logout" class="w-8 h-8"> <!-- Adjust size as needed -->
                </button>
            </form>
        </header>



        <div class="flex-1 p-6 overflow-auto">
            @yield('content')
        </div>


        <!-- Footer -->
        <footer class="bg-secondary-bg text-text-white p-4 text-center">
            <p>&copy; 2024 Gas By Gas. All rights reserved.</p>
        </footer>
    </div>
    <script>
        document.getElementById('logoutForm').addEventListener('submit', function(event) {
            event.preventDefault(); // Prevent normal form submission
            fetch(this.action, {
                method: 'POST',
                body: new FormData(this),
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                }
            }).then(response => {
                if (response.ok) {
                    window.location.href = "/login-view"; // Redirect to login page
                }
            }).catch(error => console.error('Logout failed', error));
        });
    </script>

</body>

</html>
