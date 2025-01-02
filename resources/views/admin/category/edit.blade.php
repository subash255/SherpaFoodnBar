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
  <div class="max-w-4xl mx-auto bg-white p-10 rounded-xl shadow-lg mt-[7rem] relative z-10">

    <!-- Form -->
    <form action="{{ route('admin.category.updatecategory', $category->id) }}" method="POST" enctype="multipart/form-data" class="space-y-8">
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

      <!-- Category Name Input -->
      <div class="mb-6">
        <label for="category" class="block text-lg font-medium text-gray-700">Category Name</label>
        <input type="text" id="category" name="category_name" value="{{ old('category_name', $category->category_name) }}" placeholder="Enter category name"
               class="mt-2 px-5 py-3 w-full border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-indigo-500 focus:outline-none text-lg" oninput="generateSlug()">
      </div>

      <!-- Slug Input -->
      <div class="mb-6">
        <label for="slug" class="block text-sm font-medium text-gray-700">Slug</label>
        <input type="text" id="slug" name="slug" value="{{ old('slug', $category->slug) }}" placeholder=""
               class="mt-2 px-5 py-3 w-full border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-indigo-500 focus:outline-none" readonly>
      </div>

      <!-- Current Image Display -->
      @if($category->image)
        <div class="mb-8">
          <label class="block text-lg font-medium text-gray-700">Current Image</label>
          <img src="{{ asset('images/brand/' . $category->image) }}" alt="Category Image" class="mt-3 w-64 h-auto mx-auto border border-gray-300 rounded-lg shadow-md">
        </div>
      @endif

      <!-- New Image Upload (Optional) -->
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
          Update Category
        </button>
      </div>
    </form>
  </div>

  <script>
    function generateSlug() {
      let input1 = document.getElementById('category').value;
      let slug = input1.trim().replace(/\s+/g, '-').toLowerCase();
      document.getElementById('slug').value = slug;
    }

    // Close the modal or go back to the previous page
    document.getElementById('closeModalButton').addEventListener('click', function () {
      window.history.back(); // Go back to the previous page
    });
  </script>

@endsection