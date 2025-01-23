@extends('layout.layout')

@section('content')
    <div>
        <main>
            <div id="carousel" class="relative overflow-hidden h-screen font-boogaloo">
                <!-- Carousel Wrapper -->
                <div class="carousel-inner h-full">
                    <!-- First Image -->
                    <div
                        class="carousel-item active bg-center bg-no-repeat bg-cover bg-[url('https://flowbite.s3.amazonaws.com/docs/jumbotron/conference.jpg')] h-full zoom-in-effect">
                        <div
                            class="absolute inset-0 bg-gray-800 bg-opacity-50 flex flex-col items-center justify-center text-white px-4 text-center">
                            <h1 class="text-4xl font-extrabold mb-4">We invest in the world’s potential</h1>
                            <p class="text-lg mb-6">Here at Flowbite we focus on markets where technology, innovation, and
                                capital can unlock long-term value and drive economic growth.</p>
                            <div class="flex space-x-4">
                                <a href="#"
                                    class="py-3 px-5 text-base font-medium text-white bg-text-light rounded-lg hover:text-text-dark focus:ring-4 focus:ring-blue-300">Get
                                    started</a>
                                <a href="#"
                                    class="py-3 px-5 text-base font-medium text-white border border-white rounded-lg hover:bg-gray-100 focus:ring-4 focus:ring-gray-400">Learn
                                    more</a>
                            </div>
                        </div>
                    </div>
                    <!-- Second Image -->
                    <div
                        class="carousel-item bg-center bg-no-repeat bg-cover bg-[url('https://flowbite.s3.amazonaws.com/docs/jumbotron/conference.jpg')] h-full zoom-in-effect">
                        <div
                            class="absolute inset-0 bg-gray-800 bg-opacity-50 flex flex-col items-center justify-center text-white px-4 text-center">
                            <h1 class="text-4xl font-extrabold mb-4">Innovating for the future</h1>
                            <p class="text-lg mb-6">We believe in creating solutions that shape tomorrow, ensuring a
                                sustainable and prosperous future for all.</p>
                            <div class="flex space-x-4">
                                <a href="#"
                                    class="py-3 px-5 text-base font-medium text-white bg-text-light rounded-lg hover:text-text-dark focus:ring-4 focus:ring-blue-300">Discover
                                    more</a>
                                <a href="#"
                                    class="py-3 px-5 text-base font-medium text-white border border-white rounded-lg hover:bg-gray-100 focus:ring-4 focus:ring-gray-400">Join
                                    us</a>
                            </div>
                        </div>
                    </div>
                    <!-- Third Image -->
                    <div
                        class="carousel-item bg-center bg-no-repeat bg-cover bg-[url('https://flowbite.s3.amazonaws.com/docs/jumbotron/conference.jpg')] h-full zoom-in-effect">
                        <div
                            class="absolute inset-0 bg-gray-800 bg-opacity-50 flex flex-col items-center justify-center text-white px-4 text-center">
                            <h1 class="text-4xl font-extrabold mb-4">Empowering businesses globally</h1>
                            <p class="text-lg mb-6">Our expertise drives growth and enables businesses to reach their full
                                potential in a competitive world.</p>
                            <div class="flex space-x-4">
                                <a href="#"
                                    class="py-3 px-5 text-base font-medium text-white bg-text-light rounded-lg hover:text-text-dark focus:ring-4 focus:ring-blue-300">Learn
                                    more</a>
                                <a href="#"
                                    class="py-3 px-5 text-base font-medium text-white border border-white rounded-lg hover:bg-gray-100 focus:ring-4 focus:ring-gray-400">Get
                                    in touch</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- About Us Section  and  booking  form section-->
            <div
                class="section1 md:flex md:flex-wrap items-start gap-6 md:gap-12 p-6 bg-gradient-to-br from-gray-100 to-white font-boogaloo">
                <!-- About Us Section -->
                <section class="flex-1 p-6 md:p-10 order-2 md:order-1"> <em
                        class="text-text-light text-2xl font-bold uppercase tracking-wide block mb-4">About Us</em>
                    <h1 class="text-2xl md:text-4xl font-bold text-gray-800 mb-6 leading-tight"> We Help You <span
                            class="text-text-dark">Stay Powered Safely</span> </h1>
                    <p class="text-gray-600 text-sm md:text-lg leading-relaxed mb-6"> GasByGas is a trusted LP gas
                        distributor established in Sri Lanka, committed to providing island-wide gas distribution and
                        tracking services. With several registered outlet shops and service centers across all districts, we
                        ensure a reliable supply of gas to meet your daily and industrial needs. </p>
                    <p class="text-gray-600 text-sm md:text-lg leading-relaxed mb-6"> Our innovative online gas requesting
                        and delivery system is designed to make the process seamless for end consumers. Whether you're an
                        individual or a business, our platform enables you to request gas from the nearest outlet, track
                        your token, and receive timely updates for pickups and deliveries. </p>
                    <em class="text-yellow-700 font-medium text-lg block"> Keeping your home and business running smoothly
                        is our priority. </em>
                </section>

                <!-- Booking Form Section -->
                <section class="flex-1  order-1 md:order-2">
                    <form id="form" method="POST" action="{{ route('api.issueToken') }}"
                        class="">
                        @csrf
                        <h1 class="text-2xl  md:text-4xl font-bold text-gray-800  leading-tight   ">
                            Token <span class="text-text-dark">Request</span> <span class="text-text-dark">Form</span>
                        </h1>

                        <!-- Hidden input for the logged-in user's ID -->
                        <input type="hidden" name="user_id" value="{{ $loggedInUserId }}">
                        <input type="hidden" name="token" value="{{ $assignedStatus }}">

                        <!-- Outlet Selection -->
                        <fieldset class="mb-8  px-4 md:px-8">
                            <label for="outlet" class="block text-sm font-medium text-gray-700 mb-2">Choose a
                                Outlet</label>
                            <select name="outlet_id" id="outlet"
                                class="w-full border border-gray-300 rounded-lg h-12 px-4 text-gray-800 bg-gray-50 focus:ring-2 focus:ring-yellow-500 focus:outline-none transition">
                                <option value="" disabled selected>-- Select an Outlet --</option>
                                @foreach ($outlets as $outlet)
                                    <option value="{{ $outlet->id }}"
                                        {{ $assignedOutletId == $outlet->id ? 'selected' : '' }}>
                                        {{ $outlet->Name }}
                                    </option>
                                @endforeach
                            </select>
                        </fieldset>

                        <!-- Cylinder Type Selection -->
                        <fieldset class="mb-8 p px-4 md:px-8">
                            <label for="cylinder_type" class="block text-sm font-medium text-gray-700 mb-2">Choose a
                                Cylinder
                                Type</label>
                            <select name="cylinder_type_id" id="cylinder_type"
                                class="w-full border border-gray-300 rounded-lg h-12 px-4 text-gray-800 bg-gray-50 focus:ring-2 focus:ring-yellow-500 focus:outline-none transition">
                                <option value="" disabled selected>-- Select a Cylinder Type --</option>
                                @foreach ($gasCylinders as $cylinder)
                                    <option value="{{ $cylinder->id }}">{{ $cylinder->name }}</option>
                                @endforeach
                            </select>
                        </fieldset>

                        <!-- Gas Cylinder Quantity Input (Conditionally Rendered) -->
                        @if ($assignedStatus == 4)
                            <fieldset class="mb-8  px-4 md:px-8">
                                <label for="cylinder_quantity" class="block text-sm font-medium text-gray-700 mb-2">Gas
                                    Cylinder
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
                </section>
            </div>

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
                            <img src="https://i.postimg.cc/J7yFYNtr/01.png" alt="Register"
                                class="brightness-0 invert w-16 h-16" loading="lazy">
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
                            Select the nearest outlet and request your gas cylinder. A token will be issued with the
                            expected
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


            <!--Why Choose Us Section-->
            <div
                class="section4 font-boogaloo flex flex-col md:flex-row gap-12 p-10 bg-gradient-to-br from-yellow-100 via-white to-gray-50">
                <!-- Image Section -->
                <section class="relative flex-1 flex items-center justify-center">
                    <figure class="relative w-full max-w-md overflow-hidden rounded-lg shadow-xl">
                        <img src="{{ asset('images/contacus.jpg') }}" alt="Years of experience"
                            class="w-full transform -scale-x-100 transition-transform duration-500 hover:scale-105" />
                        <span
                            class="absolute top-4 right-4 bg-white shadow-md rounded-lg text-center p-4 z-10 animate-bounce">
                            <p class="text-4xl font-black text-gray-800 leading-none">5+</p>
                            <em class="text-sm text-gray-500">Years of Experience</em>
                        </span>
                    </figure>
                </section>

                <!-- Text Content Section -->
                <section class="flex-1 space-y-6">
                    <em class="text-sm text-text-dark font-bold uppercase tracking-wide">Why Choose Us?</em>
                    <h1 class="text-3xl font-extrabold text-gray-800 leading-tight">
                        We Provide <span class="text-text-light">Top-notch Services</span> for Your Needs!
                    </h1>
                    <p class="text-gray-600 text-lg">
                        We take pride in offering premium solutions tailored to meet your unique requirements. Our team of
                        dedicated experts works around the clock to ensure that every service we provide exceeds
                        expectations. With our years of experience and commitment to excellence, we are the trusted partner
                        for many individuals and businesses.
                    </p>
                    <ul class="space-y-4">
                        <li class="flex items-start gap-3">
                            <i class="fas fa-check-circle text-text-light text-2xl"></i>
                            <span class="text-gray-700 text-lg">Over 5 years of experience in delivering exceptional
                                services.</span>
                        </li>
                        <li class="flex items-start gap-3">
                            <i class="fas fa-check-circle text-text-light text-2xl"></i>
                            <span class="text-gray-700 text-lg">Proven track record of customer satisfaction and
                                reliability.</span>
                        </li>
                        <li class="flex items-start gap-3">
                            <i class="fas fa-check-circle text-text-light text-2xl"></i>
                            <span class="text-gray-700 text-lg">Constant innovation and adoption of industry-leading
                                technologies.</span>
                        </li>
                        <li class="flex items-start gap-3">
                            <i class="fas fa-check-circle text-text-light text-2xl"></i>
                            <span class="text-gray-700 text-lg">A customer-centric approach ensuring your needs are our top
                                priority.</span>
                        </li>
                    </ul>
                </section>
            </div>


            {{-- Contact Us Section --}}
            <div class="section5 font-boogaloo  relative">
                <section
                    class="flex flex-col items-center justify-center py-12 px-6 md:px-12 rounded-xl bg-secondary_dark bg-cover bg-no-repeat bg-center relative overflow-hidden">
                    <h1
                        class="text-2xl md:text-4xl items-center justify-center text-center  font-bold text-gray-800 mb-6 leading-tight">
                        Stay connected with<span class="text-text-dark"> US</span>
                        <p class="text-black mb-6 text-lg md:text-xl max-w-xl text-center">
                            Have any questions? Feel free to contact us. We are always happy to hear from you.
                        </p>
                        <a href="/contactus"
                            class="btn1 px-6 py-3 border-2 border-black text-black text-lg font-medium rounded-lg transition-all duration-300 ease-in-out  hover:text-secondary_dark">
                            Contact us
                        </a>
                </section>

                <!-- Decorative image (adjust position for better UX) -->
                <div class="absolute right-0 top-1/4 h-full w-1/5 bg-no-repeat bg-cover"
                    style="background-image: url('{{ asset('images/homecontact.png') }}'); pointer-events: none;"></div>
            </div>



            <style>
                /* Carousel Wrapper */
                #carousel {
                    position: relative;
                }

                .carousel-inner {
                    display: flex;
                    flex-direction: column;
                }

                .carousel-item {
                    position: absolute;
                    top: 0;
                    left: 0;
                    width: 100%;
                    opacity: 0;
                    animation: none;
                    z-index: 1;
                }

                .carousel-item.active {
                    opacity: 1;
                    z-index: 2;
                    animation: zoomIn 5s ease-in-out forwards;
                }

                @keyframes zoomIn {
                    0% {
                        transform: scale(1);
                        opacity: 0;
                    }

                    100% {
                        transform: scale(1.1);
                        opacity: 1;
                    }
                }
            </style>
            <script>
                // Carousel Logic
                document.addEventListener('DOMContentLoaded', () => {
                    const items = document.querySelectorAll('.carousel-item');
                    let currentIndex = 0;

                    function showNextImage() {
                        // Set the current item to fade out
                        items[currentIndex].style.transition = "opacity 1s";
                        items[currentIndex].style.opacity = "0";

                        // Move to the next index or loop back to start
                        currentIndex = (currentIndex + 1) % items.length;

                        // Ensure the next image is visible without delay
                        items[currentIndex].classList.add('active');

                        // Delay removal of active class from previous to avoid white space
                        setTimeout(() => {
                            items.forEach((item, index) => {
                                if (index !== currentIndex) {
                                    item.classList.remove('active');
                                }
                            });
                        }, 1000);
                    }

                    // Automatically cycle through images every 5 seconds
                    setInterval(showNextImage, 10000);
                });
            </script>
        </main>

    </div>
@endsection
