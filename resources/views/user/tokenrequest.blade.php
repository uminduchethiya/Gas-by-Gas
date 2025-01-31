@extends('layout.layout')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
@section('content')
    @if (session('success'))
        <script>
            Swal.fire({
                icon: 'success',
                title: 'Success',
                text: "{{ session('success') }}",
                confirmButtonColor: '#830823'
            });
        </script>
    @endif
    @if (session('error'))
        <script>
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: "{{ session('error') }}",
                confirmButtonColor: '#830823'
            });
        </script>
    @endif
    <div style="background-image: url('{{ asset('images/contacus.jpg') }}');"
        class="bg-cover w-full md:h-[650px] h-[250px] flex items-center justify-start">
        <div class="container">
            <h1 class="text-3xl font-bold text-white md:text-5xl font-boogaloo">Token Request </h1>
            <div class="flex flex-col md:mt-3 md:flex-row text-start">
                <h1 class="flex flex-row items-center text-xl font-bold max-w-full px-4 text-white md:text-3xl">
                    <a href="{{ route('home') }}">Home</a>
                    <span class="md:mt-0"><img src="{{ asset('Images/lucide_move-left.png') }}" alt="Arrow"></span>
                    Token Request
                </h1>
            </div>
        </div>
    </div>
    <section class="flex-1 order-1 md:order-2 font-boogaloo">
        {{-- our Proceess section --}}
        <div class="section2 font-boogaloo relative bg-cover bg-no-repeat text-white py-12 px-4 md:px-8">
            <h1 class="text-2xl p-6 md:text-4xl font-bold text-gray-800 mb-6 leading-tight">
                OUR <span class="text-text-dark">PROCESS</span>
            </h1>
            <div class="flex flex-wrap md:flex-nowrap justify-center items-start p-6 gap-8">
                <!-- Step 1 -->
                <div
                    class="flex max-w-[20rem] flex-col items-center text-center p-8 bg-[#2E2303] bg-opacity-90 rounded-lg shadow-lg relative transform hover:scale-105 transition-transform duration-300">
                    <figure class="relative">
                        <img src="https://i.postimg.cc/J7yFYNtr/01.png" alt="Register" class="brightness-0 invert w-16 h-16"
                            loading="lazy">
                        <div class="absolute w-[90%] h-[50px] bg-contain bg-center bg-no-repeat top-[-20px] animate-bounce"
                            style="background-image: url('https://i.postimg.cc/7LBXbLm6/arrow.png')"></div>
                    </figure>
                    <h2 class="text-lg font-semibold mt-4 text-[#eab308]">
                        <em class="text-white">Register</em>
                    </h2>
                    <p class="text-white mt-2">
                        Create an account by providing your NIC, phone number, and email for personalized gas requests.
                    </p>
                </div>

                <!-- Step 2 -->
                <div
                    class="flex max-w-[20rem]  flex-col items-center text-center p-8 bg-[#2E2303] bg-opacity-90 rounded-lg shadow-lg relative transform hover:scale-105 transition-transform duration-300">
                    <figure class="relative">
                        <img src="https://i.postimg.cc/jSTkjBc2/02.png" alt="Request Gas"
                            class="brightness-0 invert w-16 h-16" loading="lazy">
                        <div class="absolute w-[90%] h-[50px] bg-contain bg-center bg-no-repeat top-[-20px] animate-bounce"
                            style="background-image: url('https://i.postimg.cc/7LBXbLm6/arrow.png')"></div>
                    </figure>
                    <h2 class="text-lg font-semibold mt-4 text-[#eab308]">
                        <em class="text-white">Request Gas</em>
                    </h2>
                    <p class="text-white mt-2">
                        Select the nearest outlet and request your gas cylinder. A token will be issued with the expected
                        pickup period.
                    </p>
                </div>

                <!-- Step 3 -->
                <div
                    class="flex max-w-[20rem] flex-col items-center text-center p-11 bg-[#2E2303] bg-opacity-90 rounded-lg shadow-lg relative transform hover:scale-105 transition-transform duration-300">
                    <figure class="relative">
                        <img src="https://i.postimg.cc/FKsWyc2Q/03.png" alt="Receive Updates"
                            class="brightness-0 invert w-16 h-16" loading="lazy">
                        <div class="absolute w-[90%] h-[50px] bg-contain bg-center bg-no-repeat top-[-20px] animate-bounce"
                            style="background-image: url('https://i.postimg.cc/7LBXbLm6/arrow.png')"></div>
                    </figure>
                    <h2 class="text-lg font-semibold mt-4 text-[#eab308]">
                        <em class="text-white">Receive Updates</em>
                    </h2>
                    <p class="text-white mt-2">
                        Get SMS or email notifications about your token status and delivery updates.
                    </p>
                </div>

                <!-- Step 4 -->
                <div
                    class="flex max-w-[20rem] flex-col items-center text-center p-11 bg-[#2E2303] bg-opacity-90 rounded-lg shadow-lg relative transform hover:scale-105 transition-transform duration-300">
                    <figure class="relative">
                        <img src="https://i.postimg.cc/J7yFYNtr/04.png" alt="Pickup Gas"
                            class="brightness-0 invert w-16 h-16" loading="lazy">
                    </figure>
                    <h2 class="text-lg font-semibold mt-4 text-[#eab308]">
                        <em class="text-white">Pickup Gas</em>
                    </h2>
                    <p class="text-white mt-2">
                        Visit the outlet on the scheduled date with your token to collect your gas cylinder.
                    </p>
                </div>
            </div>
        </div>


        <form id="form" method="POST" action="{{ route('api.issueToken') }}" class="bg-white p-8py-12 px-4 md:px-8">
            @csrf
            <h1 class="text-2xl p-6 md:text-4xl font-bold text-gray-800 mb-6 leading-tight py-12 px-4 md:px-8">
                Token <span class="text-text-dark">Request</span> <span class="text-gray-800">Form</span>
            </h1>

            <!-- Hidden input for the logged-in user's ID -->
            <input type="hidden" name="user_id" value="{{ $loggedInUserId }}">
            <input type="hidden" name="token" value="{{ $assignedStatus }}">
            <input type="hidden" id="user_role" value="{{ $loggedInUserRole }}">

            <!-- Outlet Selection -->
            <fieldset class="mb-8  px-4 md:px-8">
                <label for="outlet" class="block text-sm font-medium text-gray-700 mb-2">Choose a Outlet</label>
                <select name="outlet_id" id="outlet"
                    class="w-full border border-gray-300 rounded-lg h-12 px-4 text-gray-800 bg-gray-50 focus:ring-2 focus:ring-yellow-500 focus:outline-none transition">
                    <option value="" disabled selected>-- Select an Outlet --</option>
                    @foreach ($outlets as $outlet)
                        <option value="{{ $outlet->id }}" {{ $assignedOutletId == $outlet->id ? 'selected' : '' }}>
                            {{ $outlet->Name }}
                        </option>
                    @endforeach
                </select>
            </fieldset>

            <!-- Cylinder Type Selection -->
            <fieldset class="mb-8 px-4 md:px-8">
                <label for="cylinder_type" class="block text-sm font-medium text-gray-700 mb-2">Choose a Cylinder Type</label>
                <select name="cylinder_type_id" id="cylinder_type"
                    class="w-full border border-gray-300 rounded-lg h-12 px-4 text-gray-800 bg-gray-50 focus:ring-2 focus:ring-yellow-500 focus:outline-none transition">
                    <option value="" disabled selected>-- Select a Cylinder Type --</option>
                    @foreach ($gasCylinders as $cylinder)
                        <option value="{{ $cylinder->id }}"
                            data-user-price="{{ $cylinder->user_price }}"
                            data-organization-price="{{ $cylinder->organization_price }}">
                            {{ $cylinder->name }}
                        </option>
                    @endforeach
                </select>
            </fieldset>

            <!-- Price Display Field -->
            <fieldset class="mb-8 px-4 md:px-8">
                <label for="cylinder_price" class="block text-sm font-medium text-gray-700 mb-2">Per Cylinder Price (LKR)</label>
                <input type="text" id="cylinder_price" name="cylinder_price" readonly
                    class="w-full border border-gray-300 rounded-lg h-12 px-4 text-gray-800 bg-gray-50 focus:ring-2 focus:ring-yellow-500 focus:outline-none transition">
            </fieldset>

            <!-- Gas Cylinder Quantity Input (Conditionally Rendered) -->
            @if ($assignedStatus == 4)
                <fieldset class="mb-8  px-4 md:px-8">
                    <label for="cylinder_quantity" class="block text-sm font-medium text-gray-700 mb-2">Gas Cylinder
                        Quantity</label>
                    <input type="number" name="cylinder_quantity" id="cylinder_quantity"
                        class="w-full border border-gray-300 rounded-lg h-12 px-4 text-gray-800 bg-gray-50 focus:ring-2 focus:ring-yellow-500 focus:outline-none transition"
                        placeholder="Enter cylinder quantity" min="1">
                </fieldset>
            @endif


            <!-- Submit Button -->
            <fieldset class="flex justify-center">
                <button type="submit"
                    class="w-auto px-3 items-center justify-center bg-yellow-500 text-white font-medium py-3 rounded-lg hover:bg-yellow-600 hover:shadow-lg transition">
                    Submit Details
                </button>
            </fieldset>

        </form>
        <script>
            @if (session('success'))
                Swal.fire({
                    icon: 'success',
                    title: 'Success',
                    text: "{{ session('success') }}",
                    confirmButtonColor: '#830823'
                });
            @endif

            @if (session('error'))
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: "{{ session('error') }}",
                    confirmButtonColor: '#830823'
                });
            @endif

            @if ($errors->any())
                Swal.fire({
                    icon: 'error',
                    title: 'Validation Error',
                    text: "{{ $errors->first() }}",
                    confirmButtonColor: '#830823'
                });
            @endif
        </script>
        <script>
            document.addEventListener("DOMContentLoaded", function () {
                const cylinderTypeSelect = document.getElementById("cylinder_type");
                const priceInput = document.getElementById("cylinder_price");
                const userRole = document.getElementById("user_role").value;
        
                cylinderTypeSelect.addEventListener("change", function () {
                    const selectedOption = cylinderTypeSelect.options[cylinderTypeSelect.selectedIndex];
        
                    if (userRole == 3) {
                        priceInput.value = selectedOption.getAttribute("data-user-price") + " LKR";
                    } else if (userRole == 4) {
                        priceInput.value = selectedOption.getAttribute("data-organization-price") + " LKR";
                    } else {
                        priceInput.value = "N/A";
                    }
                });
            });
        </script>
        
    </section>
@endsection
