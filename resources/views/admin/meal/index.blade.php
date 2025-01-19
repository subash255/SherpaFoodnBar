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

<div class="max-w-8xl mx-auto p-4 bg-white shadow-lg mt-[7rem] rounded-lg relative z-10">
    <div class="mb-4 flex justify-end">
        <button id="openModalButton"
            class="text-red-500 font-medium bg-white border-2 border-red-500 rounded-lg py-2 px-4 hover:bg-red-600 hover:text-white transition duration-300">
            Add meal
        </button>
    </div>

    <!-- Modal Structure -->
    <div id="mealModal" class="fixed inset-0 bg-black bg-opacity-70 modal-hidden items-center justify-center z-50 backdrop-blur-[1px]">
        <div class="bg-white rounded-lg p-6 w-full max-w-lg relative">
            <h2 class="text-xl font-semibold text-center">Create New meal</h2>
            <form action="{{ route('admin.meal.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <!-- meal Name Input -->
                <div class="mb-6">
                    <label for="meal" class="block text-sm font-medium text-gray-700">meal Name</label>
                    <input type="text" id="meal" name="name" placeholder="Enter meal name"
                        class="mt-2 px-5 py-3 w-full border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-indigo-500 focus:outline-none transition duration-300 hover:border-indigo-400 text-lg" oninput="generateSlug()">
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
            <select id="entries" class="border border-gray-300 px-5 py-1 w-full sm:w-auto pr-10" onchange="updateEntries()">
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

    <!-- Table Section -->
    <div class="overflow-x-auto">
        <table id="mealTable" class="min-w-full border-collapse border border-gray-300">
            <thead>
                <tr class="bg-gray-100">
                    <th class="border border-gray-300 px-4 py-2">S.N</th>
                    <th class="border border-gray-300 px-4 py-2">meal Name</th>
                    <th class="border border-gray-300 px-4 py-2">Status</th>
                    <th class="border border-gray-300 px-4 py-2">Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($meals as $meal)
                <tr class="border border-gray-300">
                    <td class="border border-gray-300 px-4 py-2">{{ $loop->iteration }}</td>
                    <td class="border border-gray-300 px-4 py-2">{{ $meal->name }}</td>
                    <td class="border border-gray-300 px-4 py-2">
                        <label for="status{{ $meal->id }}" class="inline-flex items-center cursor-pointer">
                            <input id="status{{ $meal->id }}" type="checkbox" class="hidden toggle-switch" data-id="{{ $meal->id }}" {{ $meal->status ? 'checked' : '' }} />
                            <div class="w-10 h-6 bg-gray-200 rounded-full relative">
                                <div class="dot absolute left-1 top-1 w-4 h-4 bg-white rounded-full transition"></div>
                            </div>
                        </label>
                    </td>
                    <td class="px-2 py-2 mt-2 flex justify-center space-x-4">
                        <!-- Edit Icon -->
                        <a href="{{ route('admin.meal.edit', $meal->id) }}" class="bg-blue-500 hover:bg-blue-700 p-2 w-10 h-10 rounded-full flex items-center justify-center">
                            <i class="ri-edit-box-line text-white"></i>
                        </a>
                        <!-- Delete Icon -->
                        <form action="{{ route('admin.meal.delete', ['id' => $meal->id]) }}" method="post" onsubmit="return confirm('Are you sure you want to delete this meal?');">
                            @csrf
                            @method('delete')
                            <button class="bg-red-500 hover:bg-red-700 p-2 w-10 h-10 rounded-full flex items-center justify-center">
                                <i class="ri-delete-bin-line text-white"></i>
                            </button>
                        </form>

                        <!-- Settings Icon -->
                        <form action="{{route('admin.submeal.index',$meal->id)}} " method="get">
                            @csrf

                            <button class="bg-green-500 hover:bg-green-700 p-2 w-10 h-10 rounded-full flex items-center justify-center">
                                <i class="ri-settings-5-line text-white"></i>
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
                Showing {{ $meals->firstItem() }} to {{ $meals->lastItem() }} of {{ $meals->total() }}
                entries
            </span>
        </div>

        <div class="flex items-center space-x-2">
            {{ $meals->links() }}
        </div>
    </div>


</div>

<script>
    document.querySelectorAll('.toggle-switch').forEach(toggle => {
        const dot = toggle.parentNode.querySelector('.dot');

        // Apply the correct initial state
        if (toggle.checked) {
            dot.style.transform = 'translateX(100%)';
            dot.style.backgroundColor = 'green';
        } else {
            dot.style.transform = 'translateX(0)';
            dot.style.backgroundColor = 'white';
        }

        toggle.addEventListener('change', function() {
            const mealId = this.getAttribute('data-id');
            const newState = this.checked ? 1 : 0;

            // Toggle visual effect
            if (this.checked) {
                dot.style.transform = 'translateX(100%)';
                dot.style.backgroundColor = 'green';
            } else {
                dot.style.transform = 'translateX(0)';
                dot.style.backgroundColor = 'white';
            }

            // Send AJAX request to update the product status in the database
            fetch(`/admin/meal/update-toggle/${mealId}`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}', // CSRF token for security
                    },
                    body: JSON.stringify({
                        state: newState,
                        type: 'status',
                    }),
                })
                .then(response => response.json())
                .then(data => {
                    if (!data.success) {
                        // If the update fails, reset the toggle state
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
</script>

<script>
    // Function to generate slug from meal name
    function generateSlug() {
        let input1 = document.getElementById('meal').value;
        let slug = input1.trim().replace(/\s+/g, '-').toLowerCase();
        document.getElementById('slug').value = slug;
    }

    // Open the modal
    document.getElementById('openModalButton').addEventListener('click', function() {
        document.getElementById('mealModal').classList.remove('modal-hidden');
        document.getElementById('mealModal').classList.add('modal-visible'); // Show modal
        document.body.classList.add('overflow-hidden'); // Disable scrolling when modal is open
    });

    // Close the modal
    document.getElementById('closeModalButton').addEventListener('click', function() {
        document.getElementById('mealModal').classList.remove('modal-visible');
        document.getElementById('mealModal').classList.add('modal-hidden'); // Hide modal
        document.body.classList.remove('overflow-hidden'); // Re-enable scrolling
    });


    //search

     
    document.getElementById('search').addEventListener('input', function() {
    const searchQuery = this.value.trim().toLowerCase(); // Trim any extra spaces and convert to lowercase

    // Update the URL with the encoded search query
    history.pushState(null, null, `?search=${encodeURIComponent(searchQuery)}`);

    // Filter the table based on meal name
    filterTableByMealname(searchQuery);
});

function filterTableByMealname(query) {
    const rows = document.querySelectorAll('#mealTable tbody tr'); 
    rows.forEach(row => {
        const cells = row.getElementsByTagName('td');
        const mealCell = cells[1];  // Assuming the meal is in the first column (index 0)

        if (mealCell) {
            const mealText = mealCell.textContent.trim().toLowerCase();  // Get the meal name, trimmed and lowercase
            if (mealText.includes(query)) {  // Use 'includes' to match anywhere in the meal name
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
    filterTableByMealname(searchQuery); // Reapply the filter based on URL search query
});

</script>
@endsection