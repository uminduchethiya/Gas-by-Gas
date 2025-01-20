@extends('layout.layout')

@section('content')
<div class="container mx-auto px-4 py-12 ">
    <!-- Title -->
    <h1 class="text-4xl font-semibold text-center p-10 text-[#1F1C58] mb-12">Contact Us</h1>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-12 ">
        <!-- Contact Information Section -->
        <section class="space-y-8">
            <div>
                <h2 class="text-3xl font-bold text-gray-900 mb-6">Get in Touch with Us</h2>
                <p class="text-gray-600 leading-relaxed">
                    We are an IT solutions company based in Sri Lanka, offering innovative services to support businesses locally and internationally.
                </p>
            </div>

            <!-- Sri Lankan Branch -->
            <article class="space-y-6">
                <h3 class="text-xl font-bold flex items-center mb-4">
                    <img src="{{ asset('images/srilanka.png') }}" alt="Sri Lanka Flag" class="w-9 h-9 mr-2">
                    <span>Sri Lankan Branch</span>
                </h3>

                <div class="space-y-4">
                    <!-- Address -->
                    <div class="flex items-start gap-4">
                        <img src="{{ asset('images/address.png') }}" alt="Address Icon" class="w-10 h-10">
                        <div>
                            <p class="font-semibold">Address:</p>
                            <p>Galle, Sri Lanka</p>
                        </div>
                    </div>
                    <!-- Phone -->
                    <div class="flex items-start gap-4">
                        <img src="{{ asset('images/phone.png') }}" alt="Phone Icon" class="w-10 h-10">
                        <div>
                            <p class="font-semibold">Call Us:</p>
                            <p>+94 76 205 0235</p>
                        </div>
                    </div>
                    <!-- Email -->
                    <div class="flex items-start gap-4">
                        <img src="{{ asset('images/email.png') }}" alt="Email Icon" class="w-10 h-10">
                        <div>
                            <p class="font-semibold">Email:</p>
                            <p>info@zygenlabs.com</p>
                        </div>
                    </div>
                    <!-- Hours -->
                    <div class="flex items-start gap-4">
                        <img src="{{ asset('images/hours.png') }}" alt="Hours Icon" class="w-10 h-10">
                        <div>
                            <p class="font-semibold">Open Hours:</p>
                            <p>Mon - Fri: 9 AM - 6 PM</p>
                        </div>
                    </div>
                </div>
            </article>

            <!-- Social Media -->
            <article>
                <h3 class="text-2xl font-bold mb-4">Follow Us:</h3>
                <div class="flex space-x-4">
                    <a href="#" class="p-3 bg-blue-600 text-white rounded-full hover:bg-blue-800 transition" aria-label="Facebook">
                        <i class="fab fa-facebook-f"></i>
                    </a>
                    <a href="#" class="p-3 bg-pink-500 text-white rounded-full hover:bg-pink-700 transition" aria-label="Instagram">
                        <i class="fab fa-instagram"></i>
                    </a>
                    <a href="#" class="p-3 bg-blue-500 text-white rounded-full hover:bg-blue-700 transition" aria-label="LinkedIn">
                        <i class="fab fa-linkedin-in"></i>
                    </a>
                    <a href="#" class="p-3 bg-blue-400 text-white rounded-full hover:bg-blue-600 transition" aria-label="Twitter">
                        <i class="fab fa-twitter"></i>
                    </a>
                </div>
            </article>
        </section>

        <!-- Contact Form Section -->
        <section class="bg-white p-8 rounded-lg shadow-lg">
            <h2 class="text-2xl font-semibold mb-6 text-[#1F1C58]">Send Us a Message</h2>
            <form action="#" method="POST" class="space-y-6">
                <!-- Name Field -->
                <div>
                    <label for="name" class="block text-[#1F1C58] font-semibold mb-1">Your Name</label>
                    <input type="text" id="name" name="name" class="w-full px-4 py-2 border rounded-lg focus:ring-[#FFD700] focus:outline-none" placeholder="Enter your full name" required>
                </div>
                <!-- Email Field -->
                <div>
                    <label for="email" class="block text-[#1F1C58] font-semibold mb-1">Your Email</label>
                    <input type="email" id="email" name="email" class="w-full px-4 py-2 border rounded-lg focus:ring-[#FFD700] focus:outline-none" placeholder="Enter your email" required>
                </div>
                <!-- Message Field -->
                <div>
                    <label for="message" class="block text-[#1F1C58] font-semibold mb-1">Your Message</label>
                    <textarea id="message" name="message" rows="4" class="w-full px-4 py-2 border rounded-lg focus:ring-[#FFD700] focus:outline-none" placeholder="Write your message here" required></textarea>
                </div>
                <!-- Submit Button -->
                <button type="submit" class="w-full bg-[#FFD700] text-[#1F1C58] py-3 rounded-lg font-semibold hover:bg-[#e0b800] transition">
                    Send Message
                </button>
            </form>
        </section>
    </div>

    <!-- Google Maps Section -->
    <div class="mt-12">
        <iframe
            width="100%"
            height="700"
            frameborder="0"
            scrolling="no"
            marginheight="0"
            marginwidth="0"
            src="https://maps.google.com/maps?width=100%25&amp;height=400&amp;hl=en&amp;q=galle+(My%20Business%20Name)&amp;t=&amp;z=14&amp;ie=UTF8&amp;iwloc=B&amp;output=embed"
            class="rounded-lg shadow-lg"
        ></iframe>
    </div>
</div>
@endsection
