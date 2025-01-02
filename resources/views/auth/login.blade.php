@vite(['resources/css/app.css', 'resources/js/app.js'])
<div class="flex h-screen flex-col md:flex-row">
    <!-- Left Section (Image and Social Links) -->
    <div class="flex-1 md:flex hidden flex-col justify-between bg-gray-100 p-6">
        <div class="text-center mt-[5rem]">
            <img src="images/login.svg" alt="signin Image" class="w-[400px] mx-auto h-auto rounded-lg shadow-none">
        </div>
    </div>

    <!--Login Form -->
    <div class="flex-1 text-black p-8 flex flex-col justify-center items-center bg-gray-200">
        <h2 class="text-3xl font-bold mb-4">Admin Login</h2>
        <small class="text-black text-2xl">Welcome, Admin! Please log in to continue</small>

        <!-- Display Error Messages -->
        @if ($errors->any())
            <div class="w-full bg-red-100 text-red-600 p-4 mb-4 rounded-lg shadow-sm">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('login') }}" class="w-full max-w-md mt-8 space-y-6">
            @csrf
            <!-- Email -->
            <input id="email" type="email" name="email" value="{{ old('email') }}" required autocomplete="email" placeholder="Email"
                class="w-full p-4 rounded-lg bg-white text-black focus:outline-none focus:ring-2 focus:ring-red-500 transition-all duration-300 shadow-md">

            <!-- Password -->
            <input id="password" type="password" name="password" required autocomplete="current-password"
                placeholder="Password"
                class="w-full p-4 rounded-lg bg-white text-black focus:outline-none focus:ring-2 focus:ring-red-500 transition-all duration-300 shadow-md">

            <!-- Forgot Password -->
            <div class="flex justify-end mt-2">
                <a href="#" class="text-red-600 text-sm font-medium hover:underline">Forgot Password?</a>
            </div>

            <!-- Submit Button -->
            <button type="submit"
                class="w-full py-3 bg-red-600 text-white rounded-lg font-semibold hover:bg-red-700 transition-colors shadow-md focus:ring-2 focus:ring-red-500">
                Login
            </button>
        </form>
    </div>
</div>

