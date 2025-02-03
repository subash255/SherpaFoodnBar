@extends('layouts.app')

@section('content')

<!-- Flash Message -->
@if(session('success'))
  <div id="flash-message" class="bg-green-500 text-white px-6 py-2 rounded-lg fixed top-4 right-4 shadow-lg z-50">
      {{ session('success') }}
  </div>
@endif

<script>
    if (document.getElementById('flash-message')) setTimeout(() => {
        const msg = document.getElementById('flash-message');
        msg.style.opacity = 0;
        msg.style.transition = "opacity 0.5s ease-out";
        setTimeout(() => msg.remove(), 500);
    }, 3000);
</script>

    <div class="p-4 bg-white shadow-lg -mt-12 mx-4 z-20  rounded-lg">

    <!-- Form -->
    <form action="{{ route('admin.submeal.update', $submeals->id) }}" method="POST"  class="space-y-8" enctype="multipart/form-data"> 
        @csrf
        @method('PATCH')

        <!-- Display Errors -->
        @if ($errors->any())
            <div class="bg-red-100 text-red-700 p-4 rounded-md">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <!-- Category Dropdown -->
        <div class="mb-6">
            <label for="meal_id" class="block text-lg font-medium text-gray-700">{{$submeals->meal->name}}</label>
            <input type="hidden" name="meal_id" value="{{ $submeals->meal->id }}">
            
        </div>

        

        <!-- Subcategory Name Input -->
        <div class="mb-6">
            <label for="submeal_name" class="block text-lg font-medium text-gray-700">submeal Name</label>
            <input type="text" name="name" id="submeal_name"
                class="mt-2 px-4 py-3 w-full border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-indigo-500 focus:outline-none"
                value="{{ old('name', $submeals->name) }}" >
        </div>

          

        <!-- Submit Button -->
        <div class="flex justify-between gap-4 mt-8">
            <!-- Cancel Button -->
            <button type="button" id="closeModalButton"
                class="w-full md:w-auto bg-red-500 font-semibold text-white py-2 px-4 rounded-lg hover:bg-red-600 transition duration-300 focus:outline-none">
                Cancel
            </button>

            <!-- Submit Button -->
            <button type="submit"
                class="w-full md:w-auto bg-gradient-to-r from-indigo-600 to-indigo-700 text-white font-semibold py-2 px-6 rounded-lg hover:bg-indigo-800 focus:outline-none focus:ring-2 focus:ring-indigo-500 transition duration-300 transform hover:scale-105">
                Update submeal
            </button>
        </div>
    </form>
</div>

<script>


    // Close the modal or go back to the previous page
    document.getElementById('closeModalButton').addEventListener('click', function () {
        window.history.back(); // Go back to the previous page
    });
</script>

@endsection
