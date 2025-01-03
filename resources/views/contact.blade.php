@extends('layouts.master')
@section('content')

<!-- Contact Information Section -->
<section class="py-16 bg-gradient-to-b from-gray-50 to-gray-100 bg-cover bg-center" style="background-image: url('{{asset('images/contact.jpg')}}');">
    <div class="container mx-auto px-4 text-center">
        <h2 class="text-4xl font-extrabold text-red-600">CONTACT INFORMATION</h2>
        <div class="w-24 h-1 bg-orange-500 mx-auto mt-4"></div>
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-12 mt-10">
            <!-- Address -->
            <div class="bg-white shadow-lg rounded-xl p-8 transition-all duration-300 ease-in-out transform hover:scale-102 hover:shadow-2xl hover:bg-gray-50 flex flex-col items-center justify-center">
                <div class="flex justify-center items-center mb-6 bg-blue-100 w-20 h-20 rounded-full transition-all duration-200 ease-in-out hover:bg-blue-200">
                    <span class="text-4xl text-blue-600">
                        <i class="ri-map-pin-fill"></i>
                    </span>
                </div>
                <h3 class="font-bold text-2xl text-gray-800 mb-3 text-center">Address</h3>
                <p class="text-sm font-bold text-gray-600 text-center">96 East Central Park Road, New York, USA</p>
                <p class="text-sm font-bold text-gray-600 text-center mt-2">We are here to help you</p>
            </div>
        
            <!-- Email -->
            <div class="bg-white shadow-lg rounded-xl p-8 transition-all duration-300 ease-in-out transform hover:scale-102 hover:shadow-2xl hover:bg-gray-50 flex flex-col items-center justify-center">
                <div class="flex justify-center items-center mb-6 bg-blue-100 w-20 h-20 rounded-full transition-all duration-200 ease-in-out hover:bg-blue-200">
                    <span class="text-4xl text-blue-600">
                        <i class="ri-mail-line"></i>
                    </span>
                </div>
                <h3 class="font-bold text-2xl text-gray-800 mb-3 text-center">Email</h3>
                <a href="mailto:SherpaFoodnBar@gmail.com" class="text-sm font-bold text-gray-600 hover:text-red-600 text-center">SherpaFoodnBar@gmail.com</a>
                <p class="text-sm font-bold text-gray-600 text-center mt-2">Mail us at any time</p>
            </div>
        
            <!-- Phone -->
            <div class="bg-white shadow-lg rounded-xl p-8 transition-all duration-300 ease-in-out transform hover:scale-102 hover:shadow-2xl hover:bg-gray-50 flex flex-col items-center justify-center">
                <div class="flex justify-center items-center mb-6 bg-blue-100 w-20 h-20 rounded-full transition-all duration-200 ease-in-out hover:bg-blue-200">
                    <span class="text-4xl text-blue-600">
                        <i class="ri-phone-fill"></i>
                    </span>
                </div>
                <h3 class="font-bold text-2xl text-gray-800 mb-3 text-center">Phone</h3>
                <p class="text-sm font-bold text-gray-600 text-center">9800001111 (Whatsapp)</p>
                <p class="text-sm font-bold text-gray-600 text-center mt-2">Call us at any time</p>
            </div>
        </div>
    </div>
</section>

<!-- Get in Touch Section -->
<section class="py-16 bg-white">
    <div class="container mx-auto px-4">
        <h2 class="text-4xl font-extrabold text-red-600 text-center">GET IN TOUCH</h2>
        <div class="w-24 h-1 bg-orange-500 mx-auto mt-4 mb-10"></div>
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-12">
            <!-- Contact Form -->
            <div class="bg-white shadow-xl rounded-lg p-8">
                <h3 class="text-2xl font-bold text-red-600 mb-6">DROP A MESSAGE TO US</h3>
                <form action="#" method="POST" class="space-y-6">
                    <div>
                        <input type="text" name="name"
                            class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:ring-2 focus:ring-red-500 transition-all ease-in-out"
                            placeholder="Enter your name" required>
                    </div>
                    <div>
                        <input type="email" name="email"
                            class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:ring-2 focus:ring-red-500 transition-all ease-in-out"
                            placeholder="Enter your email" required>
                    </div>
                    <div>
                        <input type="text" name="phone"
                            class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:ring-2 focus:ring-red-500 transition-all ease-in-out"
                            placeholder="Enter your phone number">
                    </div>
                    <div>
                        <input type="text" name="subject"
                            class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:ring-2 focus:ring-red-500 transition-all ease-in-out"
                            placeholder="Subject of your inquiry" required>
                    </div>
                    <div>
                        <textarea name="message" rows="5"
                            class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:ring-2 focus:ring-red-500 transition-all ease-in-out"
                            placeholder="Write your message here"></textarea>
                    </div>

                    <button type="submit"
                        class="w-full bg-red-500 font-bold text-white py-3 rounded-lg hover:bg-red-600 focus:outline-none focus:ring-2 focus:ring-red-600 transition-all ease-in-out">Submit</button>
                </form>
            </div>

            <!-- Map -->
            <div class="bg-white rounded-lg flex justify-center items-center">
                <iframe
                    src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3151.835434509144!2d144.95373631531!3d-37.81627974212315!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x6ad642af0f11fd81%3A0xf5770f6fcd79d6e3!2sFederation%20Square!5e0!3m2!1sen!2sau!4v1572525402678!5m2!1sen!2sau"
                    width="100%" height="400" frameborder="0" style="border:0;" allowfullscreen=""
                    aria-hidden="false" tabindex="0" class="rounded-lg"></iframe>
            </div>
        </div>
    </div>
</section>

@endsection
