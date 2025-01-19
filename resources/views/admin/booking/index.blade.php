@extends('layouts.app')
@section('content')
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
            <table id="bookingTable" class="min-w-full border-collapse border border-gray-300">
                <thead>
                    <tr class="bg-gray-100">
                        <th class="border border-gray-300 px-4 py-2">S.N</th>
                        <th class="border border-gray-300 px-4 py-2">Name</th>
                        <th class="border border-gray-300 px-4 py-2">Email</th>
                        <th class="border border-gray-300 px-4 py-2">Phone number</th>
                        <th class="border border-gray-300 px-4 py-2">Total people</th>
                        <th class="border border-gray-300 px-4 py-2">Booking Date</th>
                        <th class="border border-gray-300 px-4 py-2">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($bookings as $booking)
                        <tr class="border border-gray-300">
                            <td class="border border-gray-300 px-4 py-2">{{ $loop->iteration }}</td>
                            <td class="border border-gray-300 px-4 py-2">{{ $booking->name }}</td>
                            <td class="border border-gray-300 px-4 py-2">{{ $booking->email }}</td>
                            <td class="border border-gray-300 px-4 py-2">{{ $booking->phone }}</td>
                            <td class="border border-gray-300 px-4 py-2">{{ $booking->number_of_people }}</td>
                            <td class="border border-gray-300 px-4 py-2">{{ $booking->booking_date }}</td>
                            <td class="px-2 py-2 flex justify-center space-x-4">
                                <form action="{{ route('admin.booking.destroy', ['id' => $booking->id]) }}" method="post"
                                    onsubmit="return confirm('Are you sure you want to delete this reservation item?');">
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
                    Showing {{ $bookings->firstItem() }} to {{ $bookings->lastItem() }} of
                    {{ $bookings->total() }}
                    entries
                </span>
            </div>

            <div class="flex items-center space-x-2">
                {{ $bookings->links() }}
            </div>
        </div>


    </div>

    <script>
        // Handle the search input event
        document.getElementById('search').addEventListener('input', function() {
            const searchQuery = this.value.toLowerCase(); // Get the search query, converted to lowercase

            // Update the URL without reloading the page (optional)
            history.pushState(null, null, `?search=${searchQuery}`);

            // Filter the table rows based on the search query
            filterTableByUsername(searchQuery);
        });

        // Function to filter the table rows by username (first column), progressively
        function filterTableByUsername(query) {
            const rows = document.querySelectorAll('#usersTable tbody tr'); // Select all table rows
            rows.forEach(row => {
                const cells = row.getElementsByTagName('td'); // Get all cells in the current row
                const usernameCell = cells[0]; // The first column is the username (Name)

                // Check if the username cell text starts with the search query
                if (usernameCell.textContent.toLowerCase().startsWith(query)) {
                    row.style.display = ''; // Show the row if it starts with the query
                } else {
                    row.style.display = 'none'; // Hide the row if it doesn't match
                }
            });
        }

        // Optional: Handle browser's back/forward buttons to maintain the search query
        window.addEventListener('popstate', function() {
            const urlParams = new URLSearchParams(window.location.search);
            const searchQuery = urlParams.get('search') || '';
            document.getElementById('search').value = searchQuery; // Set the search box to the value from the URL
            filterTableByUsername(searchQuery); // Filter the table based on the search query
        });
    </script>

<script>
    document.getElementById('search').addEventListener('input', function() {
        const searchQuery = this.value.toLowerCase();
        history.pushState(null, null, `?search=${searchQuery}`);
        filterTableByBookingname(searchQuery);
    });


    function filterTableByBookingname(query) {
        const rows = document.querySelectorAll('#bookingTable tbody tr');
        rows.forEach(row => {
            const cells = row.getElementsByTagName('td');
            const bookingnameCell = cells[2];

            if (bookingnameCell.textContent.toLowerCase().startsWith(query)) {
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
        filterTableByBookingname(searchQuery);
    });
</script>
@endsection
