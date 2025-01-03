@extends('layouts.master')
@section('content')

    <!-- Contact Information Section -->
    <section class="py-8">
        <div class="container mx-auto px-4 text-center">
            <h2 class="text-3xl font-bold text-red-600">CONTACT INFORMATION</h2>
            <div class="w-16 h-1 bg-orange-500 mx-auto mt-2"></div>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mt-8">
                <!-- Address -->
                <div class="bg-white shadow-lg rounded-lg p-6">
                    <div class="flex justify-center mb-4">
                        <span class="text-4xl text-blue-600">
                            <i class="fas fa-map-marker-alt"></i>
                        </span>
                    </div>
                    <h3 class="font-bold text-lg">Address</h3>
                    <p class="text-sm text-gray-600">Arabiankatu 8 LT2, 00560 Helsinki</p>
                    <p class="text-sm text-gray-600">We are here to help you</p>
                </div>
                <!-- Email -->
                <div class="bg-white shadow-lg rounded-lg p-6">
                    <div class="flex justify-center mb-4">
                        <span class="text-4xl text-blue-600">
                            <i class="fas fa-envelope"></i>
                        </span>
                    </div>
                    <h3 class="font-bold text-lg">Email</h3>
                    <p class="text-sm text-gray-600">SherpaFoodnBar@gmail.com</p>
                    <p class="text-sm text-gray-600">Mail us at any time</p>
                </div>
                <!-- Phone -->
                <div class="bg-white shadow-lg rounded-lg p-6">
                    <div class="flex justify-center mb-4">
                        <span class="text-4xl text-blue-600">
                            <i class="fas fa-phone"></i>
                        </span>
                    </div>
                    <h3 class="font-bold text-lg">Phone</h3>
                    <p class="text-sm text-gray-600">0503367896 (Whatsapp)</p>
                    <p class="text-sm text-gray-600">Call us at any time</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Get in Touch Section -->
    <section class="py-8 bg-gray-200">
        <div class="container mx-auto px-4">
            <h2 class="text-3xl font-bold text-red-600 text-center">GET IN TOUCH</h2>
            <div class="w-16 h-1 bg-orange-500 mx-auto mt-2"></div>
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mt-8">
                <!-- Contact Form -->
                <div class="bg-white shadow-lg rounded-lg p-6">
                    <h3 class="text-xl font-bold text-red-600 mb-4">DROP A MESSAGE TO US</h3>
                    <form action="#" method="POST" class="space-y-4">
                        <div>
                            <label class="block text-sm font-bold">Name:</label>
                            <input type="text" name="name" class="w-full border rounded px-3 py-2 focus:ring-2 focus:ring-red-500" required>
                        </div>
                        <div>
                            <label class="block text-sm font-bold">Email:</label>
                            <input type="email" name="email" class="w-full border rounded px-3 py-2 focus:ring-2 focus:ring-red-500" required>
                        </div>
                        <div>
                            <label class="block text-sm font-bold">Phone:</label>
                            <input type="text" name="phone" class="w-full border rounded px-3 py-2 focus:ring-2 focus:ring-red-500">
                        </div>
                        <div>
                            <label class="block text-sm font-bold">Subject:</label>
                            <input type="text" name="subject" class="w-full border rounded px-3 py-2 focus:ring-2 focus:ring-red-500">
                        </div>
                        <div>
                            <label class="block text-sm font-bold">Message:</label>
                            <textarea name="message" rows="4" class="w-full border rounded px-3 py-2 focus:ring-2 focus:ring-red-500"></textarea>
                        </div>

                        <button type="submit" class="w-full bg-red-500 text-white py-2 rounded hover:bg-red-600">Submit</button>
                    </form>
                </div>
                <!-- Map -->
                <div>
                    <iframe
                        src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3151.835434509144!2d144.95373631531!3d-37.81627974212315!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x6ad642af0f11fd81%3A0xf5770f6fcd79d6e3!2sFederation%20Square!5e0!3m2!1sen!2sau!4v1572525402678!5m2!1sen!2sau"
                        width="100%"
                        height="400"
                        frameborder="0"
                        style="border:0;"
                        allowfullscreen=""
                        aria-hidden="false"
                        tabindex="0"
                        class="rounded-lg shadow-lg"
                    ></iframe>
                </div>
            </div>
        </div>
    </section>

@endsection