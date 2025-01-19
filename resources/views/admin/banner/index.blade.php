@extends('layouts.app')
@section('content')

<style>
    .modal-hidden {
        display: none !important;
    }
    
    .modal-visible {
        display: flex !important;
    }
    </style>

{{-- Flash Message --}}
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

<div class="p-4 bg-white shadow-lg -mt-12 mx-4 z-20 rounded-lg">
    <div class="mb-4 flex justify-end">
        <button id="openModalButton"
        class="text-red-500 font-medium bg-white border-2 border-red-500 rounded-lg py-2 px-4 hover:bg-red-600 hover:text-white transition duration-300">
        Add Banner
        </button>
    </div>
    
    <!-- Modal Structure for Create Banner -->
    <div id="bannerModal" class="fixed inset-0 bg-black bg-opacity-70 modal-hidden items-center justify-center z-50 backdrop-blur-[1px]">
        <div class="bg-white rounded-lg p-6 w-full max-w-lg relative">
            <h2 class="text-xl font-semibold text-center">Create New Banner</h2>
            <form action="{{ route('admin.banner.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <!-- Banner Image Input -->
                <div class="mb-6">
                    <label for="image" class="block text-sm font-medium text-gray-700">Banner Image</label>
                    <input type="file" id="image" name="image" accept="image/*" required
                        class="mt-2 px-5 py-3 w-full border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-indigo-500 focus:outline-none transition duration-300 hover:border-indigo-400 text-lg">
                </div>

                <!-- Priority Input -->
                <div class="mb-6">
                    <label for="priority" class="block text-sm font-medium text-gray-700">Priority</label>
                    <select id="priority" name="priority" class="mt-2 px-5 py-3 w-full border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-indigo-500 focus:outline-none transition duration-300 hover:border-indigo-400 text-lg">
                        <option value="" disabled>Select priority</option>
                        @foreach ($availablePriorities as $priority)
                            <option value="{{ $priority }}" {{ old('priority') == $priority ? 'selected' : '' }}>
                                {{ $priority }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Button Container -->
                <div class="flex justify-between gap-4 mt-8">
                    <!-- Close Button -->
                    <button type="button" id="closeModalButton"
                    class="w-full md:w-auto bg-red-500 text-white py-2 px-4 font-semibold rounded-lg hover:bg-red-600 transition duration-300 focus:outline-none">
                    Cancel
                </button>

                    <!-- Submit Button -->
                    <button type="submit"
                        class="w-full md:w-auto bg-gradient-to-r from-indigo-600 to-indigo-700 text-white font-semibold py-2 px-6 rounded-lg hover:bg-indigo-800 focus:outline-none focus:ring-2 focus:ring-indigo-500 transition duration-300 transform hover:scale-105">
                        Submit
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Table Section -->
    <div class="overflow-x-auto">
        <table id="bannerTable" class="min-w-full border-separate border-spacing-0 border border-gray-300">
            <thead>
                <tr class="bg-gray-100">
                    <th class="border border-gray-300 px-4 py-2">Order</th>
                    <th class="border border-gray-300 px-4 py-2">Banner Image</th>
                    <th class="border border-gray-300 px-4 py-2">Priority</th>
                    <th class="border border-gray-300 px-4 py-2">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($banners as $banner)
                    <tr class="bg-white hover:bg-gray-50">
                        <td class="border border-gray-300 px-4 py-2 text-center">{{ $loop->iteration }}</td>
                        <td class="border border-gray-300 px-4 py-2">
                            <img src="{{ asset('banner/' . $banner->image) }}" alt="Banner Image" class="object-cover w-20 h-20 rounded">
                        </td>
                        <td class="border border-gray-300 px-4 py-2 text-center">{{ $banner->priority }}</td>
                        <td class="px-2 py-2 flex justify-center space-x-4">
                            <!-- Edit Icon -->
                            <a href="{{ route('admin.banner.edit', $banner->id) }}" class="bg-blue-500 hover:bg-blue-700 p-2 w-10 h-10 rounded-full flex items-center justify-center">
                                <i class="ri-edit-box-line text-white"></i>
                            </a>
                            <!-- Delete Icon -->
                            <form action="{{ route('admin.banner.destroy', $banner->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this banner?');">
                                @csrf
                                @method('DELETE')
                                <button class="bg-red-500 hover:bg-red-700 p-2 w-10 h-10 rounded-full flex items-center justify-center">
                                    <i class="ri-delete-bin-line text-white"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        
    </div>


</div>

<script>
// Open the modal
document.getElementById('openModalButton').addEventListener('click', function () {
    document.getElementById('bannerModal').classList.remove('modal-hidden');
    document.getElementById('bannerModal').classList.add('modal-visible');  // Show modal
    document.body.classList.add('overflow-hidden'); // Disable scrolling when modal is open
});

// Close the modal
document.getElementById('closeModalButton').addEventListener('click', function () {
    document.getElementById('bannerModal').classList.remove('modal-visible');
    document.getElementById('bannerModal').classList.add('modal-hidden'); // Hide modal
    document.body.classList.remove('overflow-hidden'); // Re-enable scrolling
});
</script>

<script>
    $(document).ready(function () {
        $('#bannerTable').DataTable({
            "pageLength": 10,
            "lengthMenu": [10, 25, 50, 100], 
            paging: true,
            searching: true,
            ordering: true,
            info: true,
            lengthChange: true,
            initComplete: function () {
                $('.dataTables_length').addClass('flex items-center gap-2 mb-4'); 
                $('select').addClass('bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 p-2 w-[4rem]'); 
            }
        });
    });
</script>

@endsection