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



    <div class="max-w-8xl mx-auto p-4 bg-white shadow-lg mt-[7rem] rounded-lg relative z-10">
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
                    <option value="">Select Category</option>
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

        <div class="flex flex-col sm:flex-row justify-between mb-4 gap-4">
            <div class="flex items-center space-x-2">
                <label for="entries" class="mr-2">Show entries:</label>
                <select id="entries" class="border border-gray-300 px-5 py-1 w-full sm:w-auto pr-10"
                    onchange="updateEntries()">
                    <option value="5" {{ request('entries') == 5 ? 'selected' : '' }}>5</option>
                    <option value="15" {{ request('entries') == 15 ? 'selected' : '' }}>15</option>
                    <option value="25" {{ request('entries') == 25 ? 'selected' : '' }}>25</option>
                </select>
            </div>

            <div class="flex items-center space-x-2 w-full sm:w-auto">
                <span class="text-gray-700">Search:</span>
                <input type="text" id="search" placeholder="Search..."
                    class="border border-gray-300 px-4 py-2 w-full sm:w-96" />
            </div>
        </div>

        <div class="overflow-x-auto">
            <!-- Table Section -->
            <table id="foodTable" class="min-w-full border-collapse border border-gray-300">
                <thead>
                    <tr class="bg-gray-100">
                        <th class="border border-gray-300 px-4 py-2">Food Name</th>
                        <th class="border border-gray-300 px-4 py-2">Category</th>
                        <th class="border border-gray-300 px-4 py-2">Type</th>
                        <th class="border border-gray-300 px-4 py-2">Price</th>
                        <th class="border border-gray-300 px-4 py-2">Status</th>
                        <th class="border border-gray-300 px-4 py-2">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($foodItems as $foodItem)
                        <tr class="border border-gray-300">
                            <td class="border border-gray-300 px-4 py-2">{{ $foodItem->name }}</td>
                            <td class="border border-gray-300 px-4 py-2">{{ optional($foodItem->category)->name }}</td>
                            <td class="border border-gray-300 px-4 py-2">{{ $foodItem->type }}</td>
                            <td class="border border-gray-300 px-4 py-2">{{ $foodItem->price }}</td>
                            <td class="border border-gray-300 px-4 py-2">
                                <label for="status{{ $foodItem->id }}" class="inline-flex items-center cursor-pointer">
                                <input id="status{{ $foodItem->id }}" type="checkbox" class="hidden toggle-switch" data-id="{{ $foodItem->id }}" {{ $foodItem->status ? 'checked' : '' }} />

                                    <div class="w-10 h-6 bg-gray-200 rounded-full relative">
                                        <div class="dot absolute left-1 top-1 w-4 h-4 bg-white rounded-full transition">
                                        </div>
                                    </div>
                                </label>
                            </td>
                            <td class="px-2 py-2 flex justify-center space-x-4">
                                <!-- Edit Icon -->
                                <a href="{{ route('admin.fooditems.edit', ['id' => $foodItem->id]) }}"
                                    class="bg-blue-500 hover:bg-blue-700 p-2 w-10 h-10 rounded-full flex items-center justify-center">
                                    <i class="ri-edit-box-line text-white"></i>
                                </a>
                                <!-- Delete Icon -->
                                <form action="{{ route('admin.fooditems.destroy', ['id' => $foodItem->id]) }}"
                                    method="post"
                                    onsubmit="return confirm('Are you sure you want to delete this food item?');">
                                    @csrf
                                    @method('delete')
                                    <button
                                        class="bg-red-500 hover:bg-red-700 p-2 w-10 h-10 rounded-full flex items-center justify-center">
                                        <i class="ri-delete-bin-line text-white"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Pagination and Show Entries Section at the Bottom -->
        <div class="flex justify-between items-center mt-4">
            <div class="flex items-center space-x-2">
                <span class="ml-4 text-gray-700">
                    Showing {{ $foodItems->firstItem() }} to {{ $foodItems->lastItem() }} of
                    {{ $foodItems->total() }}
                    entries
                </span>
            </div>

            <div class="flex items-center space-x-2">
                {{ $foodItems->links() }}
            </div>
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

        //search

        document.getElementById('search').addEventListener('input', function() {
    const searchQuery = this.value.trim().toLowerCase(); // Trim any extra spaces and convert to lowercase

    // Update the URL with the encoded search query
    history.pushState(null, null, `?search=${encodeURIComponent(searchQuery)}`);

    // Filter the table based on category name
    filterTableByfoodname(searchQuery);
});

function filterTableByfoodname(query) {
    const rows = document.querySelectorAll('#foodTable tbody tr'); 
    rows.forEach(row => {
        const cells = row.getElementsByTagName('td');
        const foodCell = cells[0];  // Assuming the food is in the first column (index 0)

        if (foodCell) {
            const foodText = foodCell.textContent.trim().toLowerCase();  // Get the food name, trimmed and lowercase
            if (foodText.includes(query)) {  // Use 'includes' to match anywhere in the food name
                row.style.display = '';  // Show the row
            } else {
                row.style.display = 'none';  // Hide the row
            }
        }
    });
}

window.addEventListener('popstate', function() {
    const urlParams = new URLSearchParams(window.location.search);
    const searchQuery = urlParams.get('search') || ''; // Default to empty if no search query
    document.getElementById('search').value = searchQuery;  // Update the search input field
    filterTableByfoodname(searchQuery); // Reapply the filter based on URL search query
});



    </script>
@endsection
