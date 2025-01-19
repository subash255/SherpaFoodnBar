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

    <!-- Flash Messages (if any) -->
    @if (session('success'))
        <div id="flash-message" class="bg-green-500 text-white px-6 py-2 rounded-lg fixed top-4 right-4 shadow-lg z-50">
            {{ session('success') }}
        </div>
    @endif

    <script>
        if (document.getElementById('flash-message')) {
            setTimeout(() => {
                const msg = document.getElementById('flash-message');
                msg.style.opacity = 0;
                msg.style.transition = "opacity 0.5s ease-out";
                setTimeout(() => msg.remove(), 500);
            }, 3000);
        }
    </script>

    <div class="p-4 bg-white shadow-lg -mt-12 mx-4 z-20 rounded-lg">
        <div class="mb-4 flex justify-end">
            <button id="openModalButton"
                class="text-red-500 font-medium bg-white border-2 border-red-500 rounded-lg py-2 px-4 hover:bg-red-600 hover:text-white transition duration-300">
                Add submeal
            </button>
        </div>

        <!-- Modal Structure -->
        <div id="submealModal"
            class="fixed inset-0 bg-black bg-opacity-70 modal-hidden items-center justify-center z-50 backdrop-blur-[1px]">
            <div class="bg-white rounded-lg p-6 w-full max-w-lg relative shadow-xl overflow-auto max-h-[90vh]">
                <h2 class="text-2xl font-semibold text-center text-gray-900 mb-8">Add Subcategory</h2>

                <form action="{{ route('admin.submeal.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <!-- Category Selection -->
                    <div class="mb-6">
                        <label for="meal" class="block text-sm font-medium text-gray-700">{{ $meal->name }}</label>
                        <input type="hidden" name="meal_id" value="{{ $meal->id }}">
                    </div>

                    <!-- submeal Name Input -->
                    <div class="mb-6">
                        <label for="submeal_name" class="block text-sm font-medium text-gray-700">Submeal Name</label>
                        <input type="text" name="name" id="submeal_name"
                            class="mt-2 px-4 py-3 w-full border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-indigo-500 focus:outline-none transition duration-300 hover:border-indigo-400 text-lg"
                            required />
                    </div>

                    <!-- Button Container -->
                    <div class="flex justify-between gap-4 mt-8">
                        <!-- Close Button -->
                        <button type="button" id="closeModalButton"
                            class="w-full md:w-auto bg-red-500 font-semibold text-white py-2 px-4 rounded-lg hover:bg-red-600 transition duration-300 focus:outline-none">
                            Cancel
                        </button>

                        <!-- Submit Button -->
                        <button type="submit"
                            class="w-full md:w-auto bg-gradient-to-r from-indigo-600 to-indigo-700 text-white font-semibold py-2 px-6 rounded-lg hover:bg-indigo-800 focus:outline-none focus:ring-2 focus:ring-indigo-500 transition duration-300 transform hover:scale-105">
                            Save Submeal
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
            <table id="submealTable" class="min-w-full border-collapse border border-gray-300">
                <thead>
                    <tr>
                        <th class="border border-gray-300 px-4 py-2">S.N</th>
                        <th class="border border-gray-300 px-4 py-2">Meal Name</th>
                        <th class="border border-gray-300 px-4 py-2">Submeal Name</th>
                        <th class="border border-gray-300 px-4 py-2">Status</th>
                        <th class="border border-gray-300 px-4 py-2">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($submeals as $submeal)
                        <tr class="border border-gray-300">
                            <td class="border border-gray-300 px-4 py-2">{{ $loop->iteration }}</td>

                            <td class="border border-gray-300 px-4 py-2">{{ $submeal->meal->name }}</td>
                            <td class="border border-gray-300 px-4 py-2">{{ $submeal->name }}</td>
                            <td class="border border-gray-300 px-4 py-2">
                                <label for="status{{ $submeal->id }}" class="inline-flex items-center cursor-pointer">
                                    <input id="status{{ $submeal->id }}" type="checkbox" class="hidden toggle-switch"
                                        data-id="{{ $submeal->id }}" {{ $submeal->status ? 'checked' : '' }} />
                                    <div class="w-10 h-6 bg-gray-200 rounded-full relative">
                                        <div class="dot absolute left-1 top-1 w-4 h-4 bg-white rounded-full transition">
                                        </div>
                                    </div>
                                </label>
                            </td>
                            <td class="px-2 py-2 mt-2 flex justify-center space-x-4">
                                <!-- Edit Icon -->
                                <a href="{{ route('admin.submeal.edit', ['id' => $submeal->id]) }}"
                                    class="bg-blue-500 hover:bg-blue-700 p-2 w-10 h-10 rounded-full flex items-center justify-center">
                                    <i class="ri-edit-box-line text-white"></i>
                                </a>
                                <!-- Delete Icon -->
                                <form action="{{ route('admin.submeal.destroy', ['id' => $submeal->id]) }}" method="post"
                                    onsubmit="return confirm('Are you sure you want to delete this submeal?');">
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

        <!-- Pagination Section -->
        <div class="flex justify-between items-center mt-4">
            <div class="flex items-center space-x-2">
                <span class="ml-4 text-gray-700">
                    Showing {{ $submeals->firstItem() }} to {{ $submeals->lastItem() }} of {{ $submeals->total() }}
                    entries
                </span>
            </div>
            <div class="flex items-center space-x-2">
                {{ $submeals->links() }}
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
                const submealId = this.getAttribute('data-id');
                const newState = this.checked ? 1 : 0;

                // Toggle visual effect
                if (this.checked) {
                    dot.style.transform = 'translateX(100%)';
                    dot.style.backgroundColor = 'green';
                } else {
                    dot.style.transform = 'translateX(0)';
                    dot.style.backgroundColor = 'white';
                }

                // Send AJAX request to update the submeal status
                fetch(`/admin/submeal/update-toggle/${submealId}`, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}', // CSRF token for security
                        },
                        body: JSON.stringify({
                            state: newState
                        }),
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (!data.success) {
                            // If update fails, reset toggle state
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
        // Function to generate slug from submeal name
        function generateSlug() {
            let input1 = document.getElementById('submeal_name').value;
            let slug = input1.trim().replace(/\s+/g, '-').toLowerCase();
            document.getElementById('slug').value = slug;
        }

        // Open the modal
        document.getElementById('openModalButton').addEventListener('click', function() {
            document.getElementById('submealModal').classList.remove('modal-hidden');
            document.getElementById('submealModal').classList.add('modal-visible'); // Show modal
            document.body.classList.add('overflow-hidden'); // Disable scrolling when modal is open
        });

        // Close the modal
        document.getElementById('closeModalButton').addEventListener('click', function() {
            document.getElementById('submealModal').classList.remove('modal-visible');
            document.getElementById('submealModal').classList.add('modal-hidden'); // Hide modal
            document.body.classList.remove('overflow-hidden'); // Re-enable scrolling
        });

        //search
        document.getElementById('search').addEventListener('input', function() {
            const searchQuery = this.value.toLowerCase();
            history.pushState(null, null, `?search=${searchQuery}`);
            filterTableBySubmealname(searchQuery);
        });

        function filterTableBySubmealname(query) {
            const rows = document.querySelectorAll('#submealTable tbody tr');
            rows.forEach(row => {
                const cells = row.getElementsByTagName('td');
                const submealnameCell = cells[2];

                if (submealnameCell.textContent.toLowerCase().startsWith(query)) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            });
        }

        window.addEventListener('popstate', function() {
            const urlParams = new URLSearchParams(window.location.search);
            const searchQuery = urlParams.get('search') || '';
            document.getElementById('search').value = searchQuery;
            filterTableBySubmealname(searchQuery);
        });
    </script>
@endsection
