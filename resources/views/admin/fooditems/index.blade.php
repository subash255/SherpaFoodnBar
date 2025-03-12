@extends('layouts.app')
@section('content')
    <style>
        /* Hide the modal */
        .modal-hidden {
            display: none !important;
        }

        /* Show the modal with flex */
        .modal-visible {
            display: flex !important;
        }
    </style>

    {{-- Flash Message --}}
    @if (session('success'))
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
                Add Items
            </button>
        </div>

        <!-- Modal Structure -->
        <div id="foodModal"
            class="fixed inset-0 bg-black bg-opacity-70 modal-hidden flex items-center justify-center z-50 backdrop-blur-[1px]">
            <div class="bg-white rounded-lg p-6 w-full sm:w-11/12 md:w-10/12 lg:w-3/4 xl:w-2/3 max-w-5xl relative">
                <h2 class="text-xl font-semibold text-center mb-6">Create New Food Item</h2>
                <form action="{{ route('admin.fooditems.store') }}" method="POST" enctype="multipart/form-data">
    @csrf

    <!-- Flex Container for Two Columns -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">

        <!-- Left Column -->
        <div class="space-y-6">

            <!-- Food Name Input -->
            <div>
                <label for="name" class="block text-sm font-medium text-gray-700">Food Name</label>
                <input type="text" id="foodname" name="name" placeholder="Enter food name"
                    class="mt-2 px-5 py-3 w-full border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-indigo-500 focus:outline-none transition duration-300 hover:border-indigo-400 text-lg"
                    required oninput="generateSlug()">
            </div>

            <!-- Slug Input (auto-generated) -->
            <div>
                <label for="slug" class="block text-sm font-medium text-gray-700">Slug</label>
                <input type="text" id="slug" name="slug" placeholder="Generated slug"
                    class="mt-2 px-5 py-3 w-full border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-indigo-500 focus:outline-none transition duration-300 hover:border-indigo-400 text-lg">
            </div>

            <!-- Price Input -->
            <div>
                <label for="price" class="block text-sm font-medium text-gray-700">Price</label>
                <input type="number" id="price" name="price" step="0.01" placeholder="Enter price"
                    class="mt-2 px-5 py-3 w-full border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-indigo-500 focus:outline-none transition duration-300 hover:border-indigo-400 text-lg"
                    required>
            </div>

            <!-- Description Input -->
            <div>
                <label for="description" class="block text-sm font-medium text-gray-700">Description</label>
                <textarea id="description" name="description" placeholder="Enter description"
                    class="mt-2 px-5 py-3 w-full border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-indigo-500 focus:outline-none transition duration-300 hover:border-indigo-400 text-lg"
                    required></textarea>
            </div>
        </div>

        <!-- Right Column -->
        <div class="space-y-6">

            <!-- Category Dropdown -->
            <div>
                <label for="category_id" class="block text-sm font-medium text-gray-700">Category</label>
                <select name="category_id" id="category_id"
                    class="mt-2 px-5 py-3 w-full border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-indigo-500 focus:outline-none transition duration-300 hover:border-indigo-400 text-lg"
                    required>
                    <option value="" disabled selected>Select Category</option>
                    @foreach ($categories as $category)
                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                    @endforeach
                </select>
            </div>

            <!-- Category Filter Dropdown -->
            <div class="mt-6 space-y-3">
                <p class="font-semibold text-gray-700">Select Food Type</p>
                <select id="category-filter"  name="type" class="text-orange-500 p-2 border rounded-lg w-full">
                    <option value="">Select Type</option>
                    <option value="veg">Veg</option>
                    <option value="non-veg">Non-Veg</option>
                    <option value="drinks">Drinks</option>
                </select>
            </div>

            <!-- Image Upload Input -->
            <div>
                <label for="image" class="block text-sm font-medium text-gray-700">Upload Image</label>
                <input type="file" id="image" name="image" accept="image/*" required
                    class="mt-2 px-5 py-3 w-full border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-indigo-500 focus:outline-none transition duration-300 hover:border-indigo-400 text-lg">
            </div>
        </div>

    </div>

    <!-- Button Container -->
    <div class="flex justify-between gap-4 mt-8">
        <!-- Close Button -->
        <button type="button" id="closeModalButton"
            class="w-full md:w-auto font-semibold bg-red-500 text-white py-2 px-4 rounded-lg hover:bg-red-600 transition duration-300 focus:outline-none">
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


        <div class="overflow-x-auto">
            <!-- Table Section -->
            <table id="foodTable" class="min-w-full border-separate border-spacing-0 border border-gray-300">
                <thead>
                    <tr class="bg-gray-100">
                        <th class="border border-gray-300 px-4 py-2">S.N</th>
                        <th class="border border-gray-300 px-4 py-2">Food Name</th>
                        <th class="border border-gray-300 px-4 py-2">Category</th>
                        <th class="border border-gray-300 px-4 py-2">Type</th>
                        <th class="border border-gray-300 px-4 py-2">Price</th>
                        <th class="border border-gray-300 px-4 py-2">Status</th>
                        <th class="border border-gray-300 px-4 py-2">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($foodItems as $foodItem)
                        <tr class="bg-white hover:bg-gray-50">
                            <td class="border border-gray-300 px-4 py-2 text-center">{{ $loop->iteration }}</td>
                            <td class="border border-gray-300 px-4 py-2">{{ $foodItem->name }}</td>
                            <td class="border border-gray-300 px-4 py-2">{{ optional($foodItem->category)->name }}</td>
                            <td class="border border-gray-300 px-4 py-2">{{ $foodItem->type }}</td>
                            <td class="border border-gray-300 px-4 py-2">€{{ $foodItem->price }}</td>
                            <td class="border border-gray-300 px-4 py-2">
                                <label for="status{{ $foodItem->id }}" class="inline-flex items-center cursor-pointer">
                                    <input id="status{{ $foodItem->id }}" type="checkbox" class="hidden toggle-switch" data-id="{{ $foodItem->id }}" {{ $foodItem->status ? 'checked' : '' }} />
                                    <div class="w-10 h-6 bg-gray-200 rounded-full relative">
                                        <div class="dot absolute left-1 top-1 w-4 h-4 bg-white rounded-full transition"></div>
                                    </div>
                                </label>
                            </td>
                            <td class="px-2 py-2 flex justify-center space-x-4 border border-gray-300">
                                <!-- Edit Icon -->
                                <a href="{{ route('admin.fooditems.edit', ['id' => $foodItem->id]) }}"
                                    class="bg-blue-500 hover:bg-blue-700 p-2 w-8 h-8 rounded-full flex items-center justify-center">
                                    <i class="ri-edit-box-line text-white"></i>
                                </a>
                                <!-- Delete Icon -->
                                <button type="button" onclick="openDeleteModal({{ $foodItem->id }})"
                                        class="bg-red-500 hover:bg-red-700 p-2 w-8 h-8 rounded-full flex items-center justify-center">
                                        <i class="ri-delete-bin-line text-white"></i>
                                    </button>
                            </td>
                        </tr>

                        <!--  deleteModal HTML -->
                <div id="deleteModal-{{ $foodItem->id }}" class="fixed inset-0 bg-black bg-opacity-70 modal-hidden items-center justify-center z-50 backdrop-blur-[1px] flex">
                    <div class="bg-white p-6 rounded-lg w-96">
                        <h2 class="text-xl font-semibold mb-4">Confirm Deletion</h2>
                        <p>Are you sure you want to delete this foodItem?</p>
                        <div class="mt-4 flex justify-end">
                            <button id="cancelBtn" class="bg-gray-400 hover:bg-gray-600 text-white p-2 rounded-md mr-2" onclick="closeDeleteModal({{ $foodItem->id }})">Cancel</button>
                            <form action="{{ route('admin.fooditems.destroy', $foodItem->id) }}" method="post">
                                @csrf
                                @method('delete')
                                <button type="submit" class="bg-red-500 hover:bg-red-700 text-white p-2 rounded-md" >Delete</button>
                            </form>
                        </div>
                    </div>
                </div>
                    @endforeach
                </tbody>
            </table>
            
        </div>


    </div>

    <script>
     document.querySelectorAll('.toggle-switch').forEach(toggle => {
    const dot = toggle.parentNode.querySelector('.dot'); // The visual dot for the toggle switch

    // Apply the correct initial state (visual toggle)
    if (toggle.checked) {
        dot.style.transform = 'translateX(100%)';
        dot.style.backgroundColor = 'green';
    } else {
        dot.style.transform = 'translateX(0)';
        dot.style.backgroundColor = 'white';
    }

    // Add event listener to handle checkbox state change
    toggle.addEventListener('change', function() {
        const foodItemId = this.getAttribute('data-id'); // Get the FoodItem ID from the data-id attribute
        const newState = this.checked ? 1 : 0; // 1 for checked, 0 for unchecked

        // Toggle visual effect of the switch
        if (this.checked) {
            dot.style.transform = 'translateX(100%)';
            dot.style.backgroundColor = 'green';
        } else {
            dot.style.transform = 'translateX(0)';
            dot.style.backgroundColor = 'white';
        }

        // Send AJAX request to update the food item status
        fetch(`/fooditem/update-toggle/${foodItemId}`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}', // CSRF token for security
            },
            body: JSON.stringify({
                state: newState, // The new state (1 or 0)
                type: 'status',  // Indicate we're updating the status
            }),
        })
        .then(response => response.json())
        .then(data => {
            if (!data.success) {
                // If update fails, reset the toggle state
                this.checked = !this.checked;
                dot.style.transform = this.checked ? 'translateX(100%)' : 'translateX(0)';
                dot.style.backgroundColor = this.checked ? 'green' : 'white';
            }
        })
        .catch(error => {
            console.error('Error:', error);
            // Reset the toggle state in case of an error
            this.checked = !this.checked;
            dot.style.transform = this.checked ? 'translateX(100%)' : 'translateX(0)';
            dot.style.backgroundColor = this.checked ? 'green' : 'white';
        });
    });
});


        // Function to generate slug from category name
        function generateSlug() {
            let input1 = document.getElementById('foodname').value;
            let slug = input1.trim().replace(/\s+/g, '-').toLowerCase();
            document.getElementById('slug').value = slug;
        }

        //Open the modal
        document.getElementById('openModalButton').addEventListener('click', function() {
            document.getElementById('foodModal').classList.remove('modal-hidden');
            document.getElementById('foodModal').classList.add('modal-visible'); // Show modal
            document.body.classList.add('overflow-hidden'); // Disable scrolling when modal is open
        });

        // Close the modal
        document.getElementById('closeModalButton').addEventListener('click', function() {
            document.getElementById('foodModal').classList.remove('modal-visible');
            document.getElementById('foodModal').classList.add('modal-hidden'); // Hide modal
            document.body.classList.remove('overflow-hidden'); // Re-enable scrolling
        });

    </script>

<script>
    $(document).ready(function () {
        $('#foodTable').DataTable({
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

    function openDeleteModal(userId) {
        const deleteModal = document.getElementById(`deleteModal-${userId}`);
        deleteModal.classList.remove('modal-hidden');
        deleteModal.classList.add('modal-visible');
        document.body.classList.add('overflow-hidden'); // Disable scrolling when modal is open
    }

    // Close the modal
    function closeDeleteModal(userId) {
        const deleteModal = document.getElementById(`deleteModal-${userId}`);
        deleteModal.classList.remove('modal-visible');
        deleteModal.classList.add('modal-hidden');
        document.body.classList.remove('overflow-hidden'); // Re-enable scrolling
    }
</script>
@endsection
