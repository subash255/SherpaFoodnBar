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

  <!-- Container -->
  <div class="p-4 bg-white shadow-lg -mt-12 mx-4 z-20  rounded-lg">


    <!-- Form -->
    <form action="{{ route('admin.fooditems.update', $foodItem->id) }}" method="POST" enctype="multipart/form-data" class="space-y-8">
      @csrf
      @method('PATCH')

      {{-- Error Message --}}
      @if ($errors->any())
        <div class="bg-red-100 text-red-700 p-4 rounded-md">
          <ul>
            @foreach ($errors->all() as $error)
              <li>{{ $error }}</li>
            @endforeach
          </ul>
        </div>
      @endif

      <!-- Food Name Input -->
      <div class="mb-6">
        <label for="name" class="block text-lg font-medium text-gray-700">Food Name</label>
        <input type="text" id="name" name="name" value="{{ old('name', $foodItem->name) }}" placeholder="Enter food name"
               class="mt-2 px-5 py-3 w-full border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-indigo-500 focus:outline-none text-lg" oninput="generateSlug()">
      </div>

      <!-- Slug Input (Auto-generated) -->
      <div class="mb-6">
        <label for="slug" class="block text-sm font-medium text-gray-700">Slug</label>
        <input type="text" id="slug" name="slug" value="{{ old('slug', $foodItem->slug) }}" placeholder=""
               class="mt-2 px-5 py-3 w-full border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-indigo-500 focus:outline-none" readonly>
      </div>

      <!-- Category Selection -->
      <div class="mb-6">
        <label for="category" class="block text-lg font-medium text-gray-700">Category</label>
        <select id="category" name="category_id" class="mt-2 px-5 py-3 w-full border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-indigo-500 focus:outline-none">
          @foreach($categories as $category)
            <option value="{{ $category->id }}" {{ $foodItem->category_id == $category->id ? 'selected' : '' }}>
              {{ $category->name }}
            </option>
          @endforeach
        </select>
      </div>

      <!-- Type Input -->
      <div class="mb-6">
        <label for="type" class="block text-lg font-medium text-gray-700">Type</label>
        <input type="text" id="type" name="type" value="{{ old('type', $foodItem->type) }}" placeholder="Enter food type"
               class="mt-2 px-5 py-3 w-full border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-indigo-500 focus:outline-none text-lg">
      </div>

      <!-- Price Input -->
      <div class="mb-6">
        <label for="price" class="block text-lg font-medium text-gray-700">Price</label>
        <input type="number" step="0.01" id="price" name="price" value="{{ old('price', $foodItem->price) }}" placeholder="Enter food price"
               class="mt-2 px-5 py-3 w-full border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-indigo-500 focus:outline-none text-lg">
      </div>

       <!-- Display Current Image -->
       @if($foodItem->image)
       <div class="mb-8">
         <label class="block text-lg font-medium text-gray-700">Current Image</label>
         <img src="{{ asset('images/fooditem/' . $foodItem->image) }}" alt="Food Image" class="mt-3 w-64 h-auto mx-auto border border-gray-300 rounded-lg shadow-md">
       </div>
     @endif

      <!-- Image Upload (Optional) -->
      <div class="mb-8">
        <label for="image" class="block text-lg font-medium text-gray-700">Upload New Image (Optional)</label>
        <input type="file" id="image" name="image" accept="image/*"
               class="mt-3 px-6 py-4 w-full border border-gray-300 rounded-lg shadow-md focus:ring-2 focus:ring-indigo-500 focus:outline-none">
      </div>

      <!-- Button Container -->
      <div class="flex justify-between gap-4 mt-8">
        <!-- Cancel Button -->
        <button type="button" id="closeModalButton" class="w-full md:w-auto bg-red-500 font-semibold text-white py-2 px-4 rounded-lg hover:bg-red-600 transition duration-300 focus:outline-none">
          Cancel
        </button>

        <!-- Submit Button -->
        <button type="submit" class="w-full md:w-auto bg-gradient-to-r from-indigo-600 to-indigo-700 text-white font-semibold py-2 px-6 rounded-lg hover:bg-indigo-800 focus:outline-none focus:ring-2 focus:ring-indigo-500 transition duration-300 transform hover:scale-105">
          Update Food Item
        </button>
      </div>
    </form>
  </div>

  <script>
    function generateSlug() {
      let input1 = document.getElementById('name').value;
      let slug = input1.trim().replace(/\s+/g, '-').toLowerCase();
      document.getElementById('slug').value = slug;
    }

    // Close the modal or go back to the previous page
    document.getElementById('closeModalButton').addEventListener('click', function () {
      window.history.back(); // Go back to the previous page
    });
  </script>

@endsection
