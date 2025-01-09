<header class="fixed z-20 flex items-center w-full bg-white h-20">
    <div class="container flex items-center justify-between font-boogaloo">
        <!-- Logo -->
        <div class="md:mt-2">
            <img src="{{ asset('images/GasLogo.png') }}" alt="Logo" class="w-20 md:w-36" />
        </div>

        <!-- Navigation Menu (Desktop) -->
        <div class="hidden md:flex items-center gap-10 text-xl">
            <a href="#" class="text-black hover:text-primaryColor">Home</a>
            <a href="#" class="text-black hover:text-primaryColor">About</a>
            <a href="#" class="text-black hover:text-primaryColor">Menu</a>
            <a href="#" class="text-black hover:text-primaryColor">Contact</a>
            <a href="#" class="text-black hover:text-primaryColor">Dealers</a>
        </div>

        <!-- Profile and Cart Dropdown -->
        <div class="flex items-center md:gap-2">
            <!-- Profile Dropdown -->
            <div class="relative inline-block text-left">
                <button id="dropdown-button" class="inline-flex justify-center items-center p-2 text-gray-600 hover:text-gray-800 focus:outline-none">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z" />
                    </svg>
                </button>

                <!-- Dropdown Menu -->
                <div id="dropdown-menu"
                    class="hidden origin-top-right absolute right-0 mt-2 w-56 rounded-md shadow-lg bg-white ring-1 ring-black ring-opacity-5">
                    <div class="py-1">
                        @guest
                            <a href="{{ route('login') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 hover:text-gray-900">Sign Up</a>
                        @endguest

                        @auth
                            @if (Auth::user()->role == 'user')
                                <a href="/user/orders"
                                    class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 hover:text-gray-900">User Dashboard</a>
                            @elseif (Auth::user()->role == 'admin')
                                <a href="/admin/dashboard"
                                    class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 hover:text-gray-900">Admin Dashboard</a>
                            @elseif (Auth::user()->role == 'cashier')
                                <a href="/cashier/dashboard"
                                    class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 hover:text-gray-900">Cashier Dashboard</a>
                            @endif

                            <a href="/user/details" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 hover:text-gray-900">Edit Profile</a>

                            <form id="logout-form">
                                @csrf
                                @method('DELETE')
                                <button type="button" onclick="showLogoutWarning()"
                                    class="w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 hover:text-gray-900">Logout</button>
                            </form>
                        @endauth
                    </div>
                </div>
            </div>

            <!-- Cart Icon -->
            <a href="#" class="text-gray-800">
                <div class="relative">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-6 w-6">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M2.25 3h1.386c.51 0 .955.343 1.087.835l.383 1.437M7.5 14.25a3 3 0 00-3 3h15.75m-12.75-3h11.218c1.121-2.3 2.1-4.684 2.924-7.138a60.114 60.114 0 00-16.536-1.84M7.5 14.25L5.106 5.272M6 20.25a.75.75 0 11-1.5 0 .75.75 0 011.5 0zm12.75 0a.75.75 0 11-1.5 0 .75.75 0 011.5 0z" />
                    </svg>
                </div>
            </a>

            @auth
                <h1 class="ml-2">Hi, {{ Auth::user()->name }}</h1>
            @endauth
        </div>
             <!-- Mobile Menu Button -->
             <button id="mobile-menu-button" class="block md:hidden focus:outline-none">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-8 h-8 text-black" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7" />
                </svg>
            </button>
    </div>

    <!-- Mobile Menu Overlay -->
    <div id="mobile-menu-overlay" class="fixed top-0 left-0 w-full h-full bg-black opacity-30 z-40 hidden"></div>

    <!-- Mobile Menu -->
    <div id="mobile-menu" class="fixed top-0 left-0 h-full w-2/3 bg-gray-800 text-white transform -translate-x-full transition-transform z-50">
        <div class="p-4 flex flex-col gap-4">
            <button id="close-mobile-menu" class="text-2xl focus:outline-none flex justify-end">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-8 h-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
            <a href="#" class="hover:text-primaryColor">Home</a>
            <a href="#" class="hover:text-primaryColor">About</a>
            <a href="#" class="hover:text-primaryColor">Menu</a>
            <a href="#" class="hover:text-primaryColor">Contact</a>
        </div>
    </div>
</header>

<script>
    const mobileMenuButton = document.getElementById('mobile-menu-button');
    const mobileMenu = document.getElementById('mobile-menu');
    const mobileMenuOverlay = document.getElementById('mobile-menu-overlay');
    const closeMobileMenu = document.getElementById('close-mobile-menu');

    // Open mobile menu
    mobileMenuButton.addEventListener('click', () => {
        mobileMenu.classList.remove('-translate-x-full');
        mobileMenuOverlay.classList.remove('hidden');
    });

    // Close mobile menu
    const closeMenu = () => {
        mobileMenu.classList.add('-translate-x-full');
        mobileMenuOverlay.classList.add('hidden');
    };

    closeMobileMenu.addEventListener('click', closeMenu);
    mobileMenuOverlay.addEventListener('click', closeMenu);
</script>