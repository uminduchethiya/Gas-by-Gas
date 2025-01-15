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
                <section class="flex-1 p-6 md:p-10 order-2 md:order-1">
                    <em class="text-text-light text-2xl  font-bold uppercase tracking-wide block mb-4">About Us</em>
                    <h1 class="text-2xl md:text-4xl font-bold text-gray-800 mb-6 leading-tight">
                        We Help You <span class="text-text-dark">Keep Your Place Clean</span>
                    </h1>
                    <p class="text-gray-600 text-sm md:text-lg leading-relaxed mb-6">
                        Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the
                        industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type
                        and scrambled it to make a type specimen book. It has survived not only five centuries, but also the
                        leap into electronic typesetting, remaining essentially unchanged.
                    </p>
                    <p class="text-gray-600 text-sm md:text-lg leading-relaxed mb-6">
                        It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages,
                        and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem
                        Ipsum.
                    </p>
                    <em class="text-yellow-700 font-medium text-lg block">It is a long established fact</em>
                </section>

                <!-- Booking Form Section -->
                <section class="flex-1 p-6 md:p-10 order-1 md:order-2">
                    <form id="form" class="bg-white p-8 md:p-10 rounded-xl shadow-2xl border border-gray-200">
                        <h2 class="text-xl md:text-2xl font-semibold text-center text-gray-800 mb-8">Book a Service</h2>
                        <fieldset class="mb-6">
                            <label for="fname" class="block text-sm font-medium text-gray-700 mb-2">Your Name</label>
                            <input type="text" name="fname" id="fname" maxlength="60"
                                class="w-full border border-gray-300 rounded-lg h-12 px-4 text-gray-800 bg-gray-50 focus:ring-2 focus:ring-yellow-500 focus:outline-none transition" />
                        </fieldset>
                        <fieldset class="mb-6">
                            <label for="cno" class="block text-sm font-medium text-gray-700 mb-2">Contact
                                Number</label>
                            <input type="tel" name="cno" maxlength="15"
                                class="w-full border border-gray-300 rounded-lg h-12 px-4 text-gray-800 bg-gray-50 focus:ring-2 focus:ring-yellow-500 focus:outline-none transition" />
                        </fieldset>
                        <fieldset class="mb-6">
                            <label for="zip" class="block text-sm font-medium text-gray-700 mb-2">Zip Code</label>
                            <input type="tel" name="zip" maxlength="8"
                                class="w-full border border-gray-300 rounded-lg h-12 px-4 text-gray-800 bg-gray-50 focus:ring-2 focus:ring-yellow-500 focus:outline-none transition" />
                        </fieldset>
                        <fieldset class="mb-8">
                            <label for="service" class="block text-sm font-medium text-gray-700 mb-2">Choose a
                                Service</label>
                            <select name="service" id="service"
                                class="w-full border border-gray-300 rounded-lg h-12 px-4 text-gray-800 bg-gray-50 focus:ring-2 focus:ring-yellow-500 focus:outline-none transition">
                                <option value="1">Residential Cleaning</option>
                                <option value="2">Commercial Cleaning</option>
                                <option value="3">Other</option>
                            </select>
                        </fieldset>
                        <fieldset>
                            <button id="form_btn"
                                class="w-full bg-yellow-500 text-white font-medium py-3 rounded-lg hover:bg-yellow-600 hover:shadow-lg transition">
                                Submit Details
                            </button>
                        </fieldset>
                    </form>
                </section>
            </div>

            {{-- our Proceess section --}}
            <div class="section2 font-boogaloo relative bg-cover bg-no-repeat text-white py-12 px-4 md:px-8"
                style="background-image: linear-gradient(to right, rgba(31, 28, 88, 0.8) 10%, rgba(31, 28, 88, 0.8) 50%, rgba(31, 28, 88, 0.8) 100%),">
                <h1 class="text-2xl p-6 md:text-4xl font-bold text-gray-800 mb-6 leading-tight">
                    OUR <span class="text-text-dark">PROCESS</span>
                </h1>
                <div class="flex flex-wrap md:flex-nowrap justify-center items-start p-6 gap-8">
                    <!-- Card 1 -->
                    <div
                        class="flex flex-col items-center text-center p-8 bg-[#2E2303] bg-opacity-90 rounded-lg shadow-lg relative transform hover:scale-105 transition-transform duration-300">
                        <figure class="relative">
                            <img src="https://i.postimg.cc/J7yFYNtr/01.png" alt="Service"
                                class="brightness-0 invert w-16 h-16" loading="lazy">
                            <div class="absolute w-[90%] h-[50px] bg-contain bg-center bg-no-repeat top-[-20px] animate-bounce"
                                style="background-image: url('https://i.postimg.cc/7LBXbLm6/arrow.png')"></div>
                        </figure>
                        <h2 class="text-lg font-semibold mt-4 text-[#eab308]">
                            Pick a <em class="text-white">service</em>
                        </h2>
                        <p class="text-white mt-2">Choose from our range of professional services tailored to meet your
                            needs.</p>
                    </div>

                    <!-- Card 2 -->
                    <div
                        class="flex flex-col items-center text-center p-8 bg-[#2E2303] bg-opacity-90 rounded-lg shadow-lg relative transform hover:scale-105 transition-transform duration-300">
                        <figure class="relative">
                            <img src="https://i.postimg.cc/jSTkjBc2/02.png" alt="Schedule"
                                class="brightness-0 invert w-16 h-16" loading="lazy">
                            <div class="absolute w-[90%] h-[50px] bg-contain bg-center bg-no-repeat top-[-20px] animate-bounce"
                                style="background-image: url('https://i.postimg.cc/7LBXbLm6/arrow.png')"></div>
                        </figure>
                        <h2 class="text-lg font-semibold mt-4 text-[#eab308]">
                            Pick a <em class="text-white">service</em>
                        </h2>
                        <p class="text-white mt-2">Choose from our range of professional services tailored to meet your
                            needs.</p>
                    </div>

                    <!-- Card 2 -->
                    <div
                        class="flex flex-col items-center text-center p-8 bg-[#2E2303] bg-opacity-90 rounded-lg shadow-lg relative transform hover:scale-105 transition-transform duration-300">
                        <figure class="relative">
                            <img src="https://i.postimg.cc/jSTkjBc2/02.png" alt="Schedule"
                                class="brightness-0 invert w-16 h-16" loading="lazy">
                            <div class="absolute w-[90%] h-[50px] bg-contain bg-center bg-no-repeat top-[-20px] animate-bounce"
                                style="background-image: url('https://i.postimg.cc/7LBXbLm6/arrow.png')"></div>
                        </figure>
                        <h2 class="text-lg font-semibold mt-4 text-[#eab308]">
                            Pick a <em class="text-white">service</em>
                        </h2>
                        <p class="text-white mt-2">Choose from our range of professional services tailored to meet your
                            needs.</p>
                    </div>

                    <!-- Card 2 -->
                    <div
                        class="flex flex-col items-center text-center p-8 bg-[#2E2303] bg-opacity-90 rounded-lg shadow-lg relative transform hover:scale-105 transition-transform duration-300">
                        <figure class="relative">
                            <img src="https://i.postimg.cc/jSTkjBc2/02.png" alt="Schedule"
                                class="brightness-0 invert w-16 h-16" loading="lazy">
                            <div class="absolute w-[90%] h-[50px] bg-contain bg-center bg-no-repeat top-[-20px] animate-bounce"
                                style="background-image: url('https://i.postimg.cc/7LBXbLm6/arrow.png')"></div>
                        </figure>
                        <h2 class="text-lg font-semibold mt-4 text-[#eab308]">
                            Pick a <em class="text-white">service</em>
                        </h2>
                        <p class="text-white mt-2">Choose from our range of professional services tailored to meet your
                            needs.</p>
                    </div>


                    <!-- Card 3 -->
                    <div
                        class="flex flex-col items-center text-center p-8 bg-[#2E2303] bg-opacity-90 rounded-lg shadow-lg relative transform hover:scale-105 transition-transform duration-300">
                        <figure class="relative">
                            <img src="https://i.postimg.cc/FKsWyc2Q/03.png" alt="Done"
                                class="brightness-0 invert w-16 h-16" loading="lazy">
                        </figure>
                        <h2 class="text-lg font-semibold mt-4 text-[#eab308]">
                            Pick a <em class="text-white">service</em>
                        </h2>
                        <p class="text-white mt-2">Choose from our range of professional services tailored to meet your
                            needs.</p>
                    </div>
                </div>
            </div>


            <!--Why Choose Us Section-->
            <div
                class="section4 font-boogaloo  flex flex-col md:flex-row gap-12 p-10 bg-gradient-to-br from-yellow-100 via-white to-gray-50">
                <!-- Image Section -->
                <section class="relative flex-1 flex items-center justify-center">
                    <figure class="relative w-full max-w-md overflow-hidden rounded-lg shadow-xl">
                        <img src="https://i.postimg.cc/YSnXb0HL/05.jpg" alt="Years of experience"
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
                        Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the
                        industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type
                        and scrambled it to make a type specimen book.
                    </p>
                    <ul class="space-y-4">
                        <li class="flex items-start gap-3">
                            <i class="fas fa-check-circle text-text-light text-2xl"></i>
                            <span class="text-gray-700 text-lg">Lorem Ipsum has been the industry's standard dummy text
                                ever since the 1500s.</span>
                        </li>
                        <li class="flex items-start gap-3">
                            <i class="fas fa-check-circle text-text-light text-2xl"></i>
                            <span class="text-gray-700 text-lg">When an unknown printer took a galley of type and scrambled
                                it to make a type specimen book.</span>
                        </li>
                        <li class="flex items-start gap-3">
                            <i class="fas fa-check-circle text-text-light text-2xl"></i>
                            <span class="text-gray-700 text-lg">It has survived not only five centuries but also the leap
                                into electronic typesetting.</span>
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
                    style="background-image: url('https://i.postimg.cc/yNvhsbQM/0.png'); pointer-events: none;"></div>
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
