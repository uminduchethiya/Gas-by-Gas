@extends('layout.layout')

@section('content')
    <div style="background-image: url('{{ asset('images/contacus.jpg') }}');"
        class="bg-cover w-full md:h-[650px] h-[250px] flex items-center justify-start">
        <div class="container">
            <h1 class="text-3xl font-bold text-white md:text-5xl font-boogaloo">Contact Us</h1>
            <div class="flex flex-col md:mt-3 md:flex-row text-start">
                <h1 class="flex flex-row items-center text-xl font-bold max-w-full px-4 text-white md:text-3xl">
                    <a href="{{ route('home') }}">Home</a>
                    <span class="md:mt-0"><img src="{{ asset('Images/lucide_move-left.png') }}" alt="Arrow"></span>
                    Contact Us
                </h1>
            </div>
        </div>
    </div>


    <div class="container mx-auto px-4 py-12 font-boogaloo ">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-12 ">
            <!-- Contact Information Section -->
            <section class="space-y-8">
                <div>
                    <h2 class="text-3xl font-bold text-gray-900 mb-6">Get in Touch with Us</h2>
                    <p class="text-gray-600 leading-relaxed">
                        We are an IT solutions company based in Sri Lanka, offering innovative services to support
                        businesses locally and internationally.
                    </p>
                </div>

                <!-- Sri Lankan Branch -->
                <article class="space-y-6">
                    

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
                            <img src="{{ asset('images/call.png') }}" alt="Phone Icon" class="w-10 h-10">
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
                                <p>info@gasbygas.com</p>
                            </div>
                        </div>
                        <!-- Hours -->
                        <div class="flex items-start gap-4">
                            <img src="{{ asset('images/openhover.png') }}" alt="Hours Icon" class="w-10 h-10">
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
                    <div class="flex flex-row gap-2 md:mt-4">
                        <i class='text-white w-6 h-6'>
                            <!DOCTYPE svg  PUBLIC ' -//W3C//DTD SVG
                            1.1//EN' 'http://www.w3.org/Graphics/SVG/1.1/DTD/svg11.dtd'><svg height="100%"
                                style="fill-rule:evenodd;clip-rule:evenodd;stroke-linejoin:round;stroke-miterlimit:2;"
                                version="1.1" viewBox="0 0 512 512" width="100%" xml:space="preserve"
                                xmlns="http://www.w3.org/2000/svg" xmlns:serif="http://www.serif.com/"
                                xmlns:xlink="http://www.w3.org/1999/xlink">
                                <path
                                    d="M449.446,0c34.525,0 62.554,28.03 62.554,62.554l0,386.892c0,34.524 -28.03,62.554 -62.554,62.554l-106.468,0l0,-192.915l66.6,0l12.672,-82.621l-79.272,0l0,-53.617c0,-22.603 11.073,-44.636 46.58,-44.636l36.042,0l0,-70.34c0,0 -32.71,-5.582 -63.982,-5.582c-65.288,0 -107.96,39.569 -107.96,111.204l0,62.971l-72.573,0l0,82.621l72.573,0l0,192.915l-191.104,0c-34.524,0 -62.554,-28.03 -62.554,-62.554l0,-386.892c0,-34.524 28.029,-62.554 62.554,-62.554l386.892,0Z"
                                    style="fill:#1777f2;" />
                            </svg>
                        </i>
                        <i class='text-white w-6 h-6'>
                            
                            <!DOCTYPE svg
                                PUBLIC '-//W3C//DTD SVG 1.1//EN' 'http://www.w3.org/Graphics/SVG/1.1/DTD/svg11.dtd'><svg
                                height="100%"
                                style="fill-rule:evenodd;clip-rule:evenodd;stroke-linejoin:round;stroke-miterlimit:2;"
                                version="1.1" viewBox="0 0 512 512" width="100%" xml:space="preserve"
                                xmlns="http://www.w3.org/2000/svg" xmlns:serif="http://www.serif.com/"
                                xmlns:xlink="http://www.w3.org/1999/xlink">
                                <g>
                                    <path
                                        d="M448,512l-384,0c-35.328,0 -64,-28.672 -64,-64l0,-384c0,-35.328 28.672,-64 64,-64l384,0c35.328,0 64,28.672 64,64l0,384c0,35.328 -28.672,64 -64,64Z"
                                        id="Dark_Blue" style="fill:#1da1f2;fill-rule:nonzero;" />
                                    <path
                                        d="M196.608,386.048c120.704,0 186.752,-100.096 186.752,-186.752c0,-2.816 0,-5.632 -0.128,-8.448c12.8,-9.216 23.936,-20.864 32.768,-34.048c-11.776,5.248 -24.448,8.704 -37.76,10.368c13.568,-8.064 23.936,-20.992 28.928,-36.352c-12.672,7.552 -26.752,12.928 -41.728,15.872c-12.032,-12.8 -29.056,-20.736 -47.872,-20.736c-36.224,0 -65.664,29.44 -65.664,65.664c0,5.12 0.64,10.112 1.664,14.976c-54.528,-2.688 -102.912,-28.928 -135.296,-68.608c-5.632,9.728 -8.832,20.992 -8.832,33.024c0,22.784 11.648,42.88 29.184,54.656c-10.752,-0.384 -20.864,-3.328 -29.696,-8.192l0,0.896c0,31.744 22.656,58.368 52.608,64.384c-5.504,1.536 -11.264,2.304 -17.28,2.304c-4.224,0 -8.32,-0.384 -12.288,-1.152c8.32,26.112 32.64,45.056 61.312,45.568c-22.528,17.664 -50.816,28.16 -81.536,28.16c-5.248,0 -10.496,-0.256 -15.616,-0.896c28.928,18.432 63.488,29.312 100.48,29.312"
                                        id="Logo__x2014__FIXED" style="fill:#fff;fill-rule:nonzero;" />
                                </g>
                            </svg>
                        </i>
                        <i class='text-white w-6 h-6'>
                            
                            <!DOCTYPE svg
                                PUBLIC '-//W3C//DTD SVG 1.1//EN' 'http://www.w3.org/Graphics/SVG/1.1/DTD/svg11.dtd'><svg
                                height="100%"
                                style="fill-rule:evenodd;clip-rule:evenodd;stroke-linejoin:round;stroke-miterlimit:2;"
                                version="1.1" viewBox="0 0 512 512" width="100%" xml:space="preserve"
                                xmlns="http://www.w3.org/2000/svg" xmlns:serif="http://www.serif.com/"
                                xmlns:xlink="http://www.w3.org/1999/xlink">
                                <g id="WhatsApp-Logo-Icon">
                                    <path
                                        d="M116.225,-0.001c-11.264,0.512 -26.112,1.536 -32.768,3.072c-10.24,2.048 -19.968,5.12 -27.648,9.216c-9.728,4.608 -17.92,10.752 -25.088,17.92c-7.68,7.68 -13.824,15.872 -18.432,25.6c-4.096,7.68 -7.168,17.408 -9.216,27.648c-1.536,6.656 -2.56,21.504 -2.56,32.768c-0.512,4.608 -0.512,10.752 -0.512,13.824l0,251.905l0,13.824c0.512,11.264 1.536,26.112 3.072,32.768c2.048,10.24 5.12,19.968 9.216,27.648c4.608,9.728 10.752,17.92 17.92,25.088c7.68,7.68 15.872,13.824 25.6,18.432c7.68,4.096 17.408,7.168 27.648,9.216c6.656,1.536 21.504,2.56 32.768,2.56c4.608,0.512 10.752,0.512 13.824,0.512l251.904,0l13.824,0c11.264,-0.512 26.112,-1.536 32.768,-3.072c10.24,-2.048 19.968,-5.12 27.648,-9.216c9.728,-4.608 17.92,-10.752 25.088,-17.92c7.68,-7.68 13.824,-15.872 18.432,-25.6c4.096,-7.68 7.168,-17.408 9.216,-27.648c1.536,-6.656 2.56,-21.504 2.56,-32.768c0.512,-4.608 0.512,-10.752 0.512,-13.824l0,-265.729c-0.512,-11.264 -1.536,-26.112 -3.072,-32.768c-2.048,-10.24 -5.12,-19.968 -9.216,-27.648c-4.608,-9.728 -10.752,-17.92 -17.92,-25.088c-7.68,-7.68 -15.872,-13.824 -25.6,-18.432c-7.68,-4.096 -17.408,-7.168 -27.648,-9.216c-6.656,-1.536 -21.504,-2.56 -32.768,-2.56c-4.608,-0.512 -10.752,-0.512 -13.824,-0.512l-265.728,0Z"
                                        style="fill:url(#_Linear1);fill-rule:nonzero;" />
                                    <path
                                        d="M344.754,289.698c-4.56,-2.282 -26.98,-13.311 -31.161,-14.832c-4.18,-1.521 -7.219,-2.282 -10.259,2.282c-3.041,4.564 -11.78,14.832 -14.44,17.875c-2.66,3.042 -5.32,3.423 -9.88,1.14c-4.561,-2.281 -19.254,-7.095 -36.672,-22.627c-13.556,-12.087 -22.709,-27.017 -25.369,-31.581c-2.66,-4.564 -0.283,-7.031 2,-9.304c2.051,-2.041 4.56,-5.324 6.84,-7.986c2.28,-2.662 3.04,-4.564 4.56,-7.606c1.52,-3.042 0.76,-5.705 -0.38,-7.987c-1.14,-2.282 -10.26,-24.72 -14.06,-33.848c-3.701,-8.889 -7.461,-7.686 -10.26,-7.826c-2.657,-0.132 -5.7,-0.16 -8.74,-0.16c-3.041,0 -7.98,1.141 -12.161,5.704c-4.18,4.564 -15.96,15.594 -15.96,38.032c0,22.438 16.34,44.116 18.62,47.159c2.281,3.043 32.157,49.089 77.902,68.836c10.88,4.697 19.374,7.501 25.997,9.603c10.924,3.469 20.866,2.98 28.723,1.806c8.761,-1.309 26.98,-11.029 30.781,-21.677c3.799,-10.649 3.799,-19.777 2.659,-21.678c-1.139,-1.902 -4.179,-3.043 -8.74,-5.325m-83.207,113.573l-0.061,0c-27.22,-0.011 -53.917,-7.32 -77.207,-21.137l-5.539,-3.287l-57.413,15.056l15.325,-55.959l-3.608,-5.736c-15.184,-24.145 -23.203,-52.051 -23.192,-80.704c0.033,-83.611 68.083,-151.635 151.756,-151.635c40.517,0.016 78.603,15.811 107.243,44.474c28.64,28.663 44.404,66.764 44.389,107.283c-0.035,83.617 -68.083,151.645 -151.693,151.645m129.102,-280.709c-34.457,-34.486 -80.281,-53.487 -129.103,-53.507c-100.595,0 -182.468,81.841 -182.508,182.437c-0.013,32.156 8.39,63.546 24.361,91.212l-25.892,94.545l96.75,-25.37c26.657,14.535 56.67,22.194 87.216,22.207l0.075,0c100.586,0 182.465,-81.852 182.506,-182.448c0.019,-48.751 -18.946,-94.59 -53.405,-129.076"
                                        style="fill:#fff;" />
                                </g>
                                <defs>
                                    <linearGradient gradientTransform="matrix(0,-512,-512,0,256.001,512)"
                                        gradientUnits="userSpaceOnUse" id="_Linear1" x1="0" x2="1"
                                        y1="0" y2="0">
                                        <stop offset="0" style="stop-color:#25cf43;stop-opacity:1" />
                                        <stop offset="1" style="stop-color:#61fd7d;stop-opacity:1" />
                                    </linearGradient>
                                </defs>
                            </svg>
                        </i>
                </div>
                </article>
            </section>

            <!-- Contact Form Section -->
            <section class="bg-white p-8 rounded-lg shadow-lg">
                <h2 class="text-2xl font-semibold mb-6 ">Send Us a Message</h2>
                <form action="{{ route('contact.submit') }}" method="POST" class="space-y-6">
                    @csrf
                    <!-- Name Field -->
                    <div>
                        <label for="name" class="block  font-semibold mb-1">Your Name</label>
                        <input type="text" id="name" name="name"
                            class="w-full px-4 py-2 border rounded-lg focus:ring-[#FFD700] focus:outline-none"
                            placeholder="Enter your full name" required>
                    </div>
                    <!-- Email Field -->
                    <div>
                        <label for="email" class="block  font-semibold mb-1">Your Email</label>
                        <input type="email" id="email" name="email"
                            class="w-full px-4 py-2 border rounded-lg focus:ring-[#FFD700] focus:outline-none"
                            placeholder="Enter your email" required>
                    </div>
                    <!-- Message Field -->
                    <div>
                        <label for="message" class="block  font-semibold mb-1">Your Message</label>
                        <textarea id="message" name="message" rows="4"
                            class="w-full px-4 py-2 border rounded-lg focus:ring-[#FFD700] focus:outline-none"
                            placeholder="Write your message here" required></textarea>
                    </div>
                    <!-- Submit Button -->
                    <button type="submit"
                        class="w-full bg-[#FFD700]  py-3 rounded-lg font-semibold hover:bg-[#e0b800] transition">
                        Send Message
                    </button>
                </form>
            </section>
        </div>

        <!-- Google Maps Section -->
        <div class="mt-12">
            <iframe width="100%" height="700" frameborder="0" scrolling="no" marginheight="0" marginwidth="0"
                src="https://maps.google.com/maps?width=100%25&amp;height=400&amp;hl=en&amp;q=galle+(My%20Business%20Name)&amp;t=&amp;z=14&amp;ie=UTF8&amp;iwloc=B&amp;output=embed"
                class="rounded-lg shadow-lg"></iframe>
        </div>
    </div>
@endsection
