<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GAS BY GAS USER REGISTER</title>
    @vite('resources/css/app.css')
    <!-- Include SweetAlert2 CSS and JS -->
<link href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
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
@if (session('status') == 'error')
    <script>
        Swal.fire({
            icon: 'error',
            title: 'Error',
            text: "{{ session('message') }}",
        });
    </script>
@elseif (session('status') == 'success')
    <script>
        Swal.fire({
            icon: 'success',
            title: 'Success',
            text: "{{ session('message') }}",
        });
    </script>
@endif
<body class="flex items-center justify-center min-h-screen bg-main-bg font-mono">
    
    <!-- Login Container -->
    <div
        class="w-full max-w-md p-8 space-y-6 bg-secondary-bg rounded-lg shadow-md transform transition-transform duration-300 ease-in-out hover:scale-105">
        <!-- Branding / Logo -->
        <div class="text-center animated-logo">
            <h2 class="text-3xl font-bold text-text-primary">Gas By Gas</h2>
            <p class="text-text-secondary">User Registration</p>
        </div>

        <!-- Login Form -->
        <form method="POST" action="{{ route('register.api') }}" class="space-y-4 animated-form"
            enctype="multipart/form-data">
            @csrf
            <!-- Name Input -->
            <div>
                <label for="name" class="block text-sm font-medium text-text-secondary">Name</label>
                <input type="text" id="name" name="name" required
                    class="w-full px-4 py-2 mt-1 border rounded-lg focus:outline-none focus:ring-2 focus:ring-accent-1 focus:border-transparent border-accent-2 text-text-white bg-main-bg"
                    placeholder="Enter your name">
            </div>

            <!-- Email Input -->
            <div>
                <label for="email" class="block text-sm font-medium text-text-secondary">Email</label>
                <input type="email" id="email" name="email" required
                    class="w-full px-4 py-2 mt-1 border rounded-lg focus:outline-none focus:ring-2 focus:ring-accent-1 focus:border-transparent border-accent-2 text-text-white bg-main-bg"
                    placeholder="Enter your email">
            </div>

            <!-- Password Input -->
            <div>
                <label for="password" class="block text-sm font-medium text-text-secondary">Password</label>
                <input type="password" id="password" name="password" required
                    class="w-full px-4 py-2 mt-1 border rounded-lg focus:outline-none focus:ring-2 focus:ring-accent-1 focus:border-transparent border-accent-2 text-text-white bg-main-bg"
                    placeholder="Enter your password">
            </div>

            <!-- Confirm Password Input -->
            <div>
                <label for="confirm-password" class="block text-sm font-medium text-text-secondary">Confirm
                    Password</label>
                <input type="password" id="confirm-password" name="password_confirmation" required
                    class="w-full px-4 py-2 mt-1 border rounded-lg focus:outline-none focus:ring-2 focus:ring-accent-1 focus:border-transparent border-accent-2 text-text-white bg-main-bg"
                    placeholder="Re-enter your password">
            </div>

            <!-- NIC-->
            <div>
                <label for="nic" class="block text-sm font-medium text-text-secondary">NIC</label>
                <input type="text" id="nic" name="nic" required
                    class="w-full px-4 py-2 mt-1 border rounded-lg focus:outline-none focus:ring-2 focus:ring-accent-1 focus:border-transparent border-accent-2 text-text-white bg-main-bg"
                    placeholder="Enter 12-digit NIC or 9-digit NIC ending with V/X">
                <small class="text-sm text-gray-400">Old NIC: 123456789V | New NIC: 123456789012</small>
            </div>

            <!-- Address Input -->
            <div>
                <label for="address" class="block text-sm font-medium text-text-secondary">Address</label>
                <input type="text" id="address" name="address" required
                    class="w-full px-4 py-2 mt-1 border rounded-lg focus:outline-none focus:ring-2 focus:ring-accent-1 focus:border-transparent border-accent-2 text-text-white bg-main-bg"
                    placeholder="Enter your address">
            </div>

            <!-- Contact Number Input -->
            <div>
                <label for="contact-number" class="block text-sm font-medium text-text-secondary">Contact Number</label>
                <input type="tel" id="contact-number" name="contact_number" required
                    class="w-full px-4 py-2 mt-1 border rounded-lg focus:outline-none focus:ring-2 focus:ring-accent-1 focus:border-transparent border-accent-2 text-text-white bg-main-bg"
                    placeholder="+94XXXXXXXXX">
                <small class="text-sm text-gray-400">Enter the phone number in the format +94XXXXXXXXX.</small>
            </div>

            <!-- Branch Input -->
            <div>
                <label for="outlet" class="block text-sm font-medium text-text-secondary">Outlet</label>
                <select id="outlet" name="outlet" required
                    class="w-full px-4 py-2 mt-1 border rounded-lg focus:outline-none focus:ring-2 focus:ring-accent-1 focus:border-transparent border-accent-2 text-text-white bg-main-bg">
                    <option value="">Select a branch</option>
                    @foreach ($outlets as $outlet)
                        <option value="{{ $outlet->id }}">{{ $outlet->Name }}</option>
                    @endforeach
                </select>
            </div>

            <!-- Organization Checkbox -->
            <div class="flex items-center">
                <input type="checkbox" id="is-organization" name="is_organization" value="1" class="mr-2"
                    onclick="toggleVerificationFile()">
                <label for="is-organization" class="text-sm font-medium text-text-secondary">Are you an
                    organization?</label>
            </div>

            <!-- Verification File Input -->
            <div id="verification-file-container" class="hidden">
                <label for="verification-file" class="block text-sm font-medium text-text-secondary">Verification
                    File</label>
                <input type="file" id="verification-file" name="verification_file"
                    class="w-full px-4 py-2 mt-1 border rounded-lg focus:outline-none focus:ring-2 focus:ring-accent-1 focus:border-transparent border-accent-2 text-text-white bg-main-bg">
            </div>

            <!-- Register Button -->
            <div>
                <button type="submit"
                    class="w-full px-4 py-2 font-semibold text-white bg-accent-1 rounded-lg hover:bg-accent-2 focus:outline-none focus:bg-accent-2 transition duration-200">
                    Register
                </button>
            </div>
            <script>
                function toggleVerificationFile() {
                    const checkbox = document.getElementById('is-organization');
                    const fileContainer = document.getElementById('verification-file-container');
                    if (!checkbox.checked) {
                        document.getElementById('verification-file').value = ''; // Clear file input if unchecked
                    }
                    fileContainer.classList.toggle('hidden', !checkbox.checked);
                }
            </script>
           <script>
            document.querySelector('.animated-form').addEventListener('submit', function (e) {
                const nic = document.getElementById('nic').value.trim();
                const contactNumber = document.getElementById('contact-number').value.trim();
        
                const nicRegex = /^\d{12}$|^\d{9}[vVxX]$/; // NIC validation
                const phoneRegex = /^\+94\d{9}$/; // Phone number validation
        
                if (!nicRegex.test(nic)) {
                    e.preventDefault();
                    Swal.fire({
                        icon: 'error',
                        title: 'Invalid NIC Format',
                        text: 'Please enter a valid NIC. Use 12 digits for the new NIC or 9 digits followed by V/v or X/x for the old NIC.',
                    });
                    return;
                }
        
                if (!phoneRegex.test(contactNumber)) {
                    e.preventDefault();
                    Swal.fire({
                        icon: 'error',
                        title: 'Invalid Phone Number Format',
                        text: 'Please enter a valid phone number. It should start with +94 followed by 9 digits.',
                    });
                    return;
                }
            });
        </script>
        </form>
        <!-- Forgot Password Link -->
        <div class="text-center">
            <a href="/login-view" class="text-sm text-accent-1 hover:underline">Login</a>
        </div>
    </div>

</body>

</html>
