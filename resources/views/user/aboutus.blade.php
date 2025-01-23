@extends('layout.layout')

@section('content')
    <div style="background-image: url('{{ asset('images/aboutus.jpg') }}');"
        class="bg-cover  w-full md:h-[550px] h-[250px] flex items-center justify-start">
        <div class="container">
            <h1 class="text-3xl font-bold text-white md:text-5xl font-boogaloo">About Us</h1>
            <div class="flex flex-col md:mt-3 md:flex-row text-start">
                <h1 class="flex flex-row items-center text-xl font-bold max-w-full px-4 text-white md:text-3xl">
                    <a href="{{ route('home') }}">Home</a>
                    <span class="md:mt-0"><img src="{{ asset('Images/lucide_move-left.png') }}" alt="Arrow"></span>
                    About Us
                </h1>
            </div>
        </div>
    </div>
    <div>
        <section class="flex-1 p-6 md:p-10 order-2 md:order-1 font-boogaloo">
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

        <div class="container">
            <div class="container">
                <div class="px-5 py-10">
                    <div class="">
                        <div class="flex justify-center">
                            <h1 class="text-3xl font-bold text-primaryColor md:text-5xl">Customer <span
                                    class="text-black">Reviews</span>
                            </h1>
                        </div>
                        <p class="flex justify-center text-2xl font-bold text-gray-700">
                            Lorem Ipsum is simply dummy text of the printing
                        </p>

                        <!-- FLICKITY CAROUSEL -->
                        <link rel="stylesheet" href="https://unpkg.com/flickity@2/dist/flickity.min.css">
                        <script src="https://unpkg.com/flickity@2/dist/flickity.pkgd.min.js"></script>

                        <div class="main-carousel h-[410px] mt-10"
                            data-flickity='{
                        "cellAlign": "left",
                        "wrapAround": true,
                        "pageDots": true,
                        "draggable": true
                    }'>

                            @for ($i = 1; $i <= 3; $i++)
                                <div class="carousel-cell">
                                    <div
                                        class="carasoul_width w-full h-full px-5 md:w-[459px] md:h-[400px] flex flex-col justify-center md:gap-4">
                                        <div
                                            class="test w-full p-2 py-10 mx-auto mt-10  bg-[url('../images/Group74.png')] bg-cover bg-center  rounded-3xl md:h-[440px] h-[320px]">

                                            <div class="w-full rounded-3xl md:h-[200px] md:mt-10">
                                                <p class="text-[12px] font-bold text-center text-black md:text-md w-full">
                                                    Lorem
                                                    Ipsum is simply dummy text of the printing and typesetting industry.
                                                    Lorem
                                                    Ipsum has been the industry's standard dummy text ever since the 1500s
                                                    Lorem
                                                    Ipsum is simply</p>
                                                <div class="flex items-center justify-center md:mt-8 2xl:mt-12">
                                                    <img src="{{ asset('Images/Group76.png') }}">
                                                </div>
                                                <p class="text-xl font-bold text-center text-white md:text-2xl">Sam Perera
                                                </p>
                                                <p class="text-xl font-bold text-center text-white md:text-md">Driver</p>
                                                <div class="flex justify-center gap-2 md:mt-2 mt-2">
                                                    <img src="{{ asset('Images/Group.2.png') }}">
                                                    <img src="{{ asset('Images/Vector.png') }}">
                                                    <img src="{{ asset('Images/Vector.1.png') }}">

                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endfor

                        </div>
                    </div>
                </div>
            </div>

        </div>

        <style>
            @media only screen and (width: 1280px) {
                .test {
                    width: 200px;
                }

                .carasoul_width {
                    width: 350px;
                }

                /* Add more rules for other elements if needed */
            }

            @media only screen and (width: 1792px) {
                .test {
                    width: 250px;
                }

                .carasoul_width {
                    width: 320px;
                }

                /* Add more rules for other elements if needed */
            }


            @media only screen and (min-width: 1366px) and (max-width: 1512px) {
                .test {
                    width: 340px;
                    /* Adjust the width as needed */
                }

                .carasoul_width {
                    width: 470px;
                    /* Adjust the width as needed */
                }

                /* Add more rules for other elements if needed */
            }


            @media only screen and (width: 1920px) {
                .car_text_margin {
                    position: relative;
                    left: 70px;
                }

                .car_logos img {
                    width: 250px;
                }

                @media (max-width: 767px) {

                    /* Hide background image on screens smaller than 768px width */
                    .md\:flex {
                        background-image: none;
                    }
                }
            }
        </style>
    </div>
@endsection
