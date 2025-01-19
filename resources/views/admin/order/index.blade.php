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

    <div class="p-4 bg-white shadow-lg -mt-12 mx-4 z-20  rounded-lg">
        <div class="flex justify-end gap-2 mb-4">
            <a href="{{ route('admin.order.index', ['status' => 'pending', 'entries' => request('entries')]) }}"
                class="border-2 {{ request('status') == 'pending' ? 'bg-blue-500 text-white' : 'border-blue-500 text-blue-500' }} font-bold px-6 py-1 rounded-lg hover:bg-blue-500 hover:text-white">
                Pending
            </a>
            <a href="{{ route('admin.order.index', ['status' => 'delivered', 'entries' => request('entries')]) }}"
                class="border-2 {{ request('status') == 'delivered' ? 'bg-green-500 text-white' : 'border-green-500 text-green-500' }} font-bold px-6 py-1 rounded-lg hover:bg-green-500 hover:text-white">
                Delivered
            </a>
            <a href="{{ route('admin.order.index', ['status' => 'rejected', 'entries' => request('entries')]) }}"
                class="border-2 {{ request('status') == 'rejected' ? 'bg-red-500 text-white' : 'border-red-500 text-red-500' }} font-bold px-6 py-1 rounded-lg hover:bg-red-500 hover:text-white">
                Rejected
            </a>
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
            <table id="usersTable" class="min-w-full border-collapse border border-gray-300">
                <thead>
                    <tr class="bg-gray-100">
                        <th class="border border-gray-300 px-4 py-2">S.N</th>
                        <th class="border border-gray-300 px-4 py-2">Name</th>
                        <th class="border border-gray-300 px-4 py-2">Email</th>
                        <th class="border border-gray-300 px-4 py-2">Contact</th>
                        <th class="border border-gray-300 px-4 py-2">Payment Method</th>
                        <th class="border border-gray-300 px-4 py-2">Price</th>
                        <th class="border border-gray-300 px-4 py-2">Order Num</th>
                        <th class="border border-gray-300 px-4 py-2">Status</th>
                        {{-- <th class="border border-gray-300 px-4 py-2">Items</th> --}}
                        <th class="border border-gray-300 px-4 py-2">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($orders as $order)
                        <tr class="border border-gray-300">
                            <td class="border border-gray-300 px-4 py-2">{{ $loop->iteration }}</td>
                            <td class="border border-gray-300 px-4 py-2">{{ $order->name }}</td>
                            <td class="border border-gray-300 px-4 py-2">{{ $order->email }}</td>
                            <td class="border border-gray-300 px-4 py-2">{{ $order->phone }}</td>
                            <td class="border border-gray-300 px-4 py-2">{{ ucfirst($order->payment_method) }} </td>
                            <td class="border border-gray-300 px-4 py-2">${{ number_format($order->total, 2) }}</td>
                            <td class="border border-gray-300 px-4 py-2">{{ $order->order_number }}</td>
                            <td class="border border-gray-300 px-4 py-2">{{ ucfirst($order->status) }}</td>

                            {{-- <td class="py-3 px-4 border-b">
                                <!-- Loop through the items array to display each item in separate rows -->
                                <table class="min-w-full">
                                    <thead>
                                        <tr>
                                            <th class="border border-gray-300 px-4 py-2">Name</th>
                                            <th class="border border-gray-300 px-4 py-2">Price</th>
                                            <th class="border border-gray-300 px-4 py-2">Description</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($order->items as $item)
                                            <tr>
                                                <td class="border border-gray-300 px-4 py-2">{{ $item['name'] }}</td>
                                                <td class="border border-gray-300 px-4 py-2">
                                                    ${{ number_format($item['price'], 2) }}</td>
                                                <td class="border border-gray-300 px-4 py-2">{{ $item['description'] }}
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </td> --}}

                            <td class="px-2 py-2 flex justify-center space-x-4">

                                <form action="{{ route('admin.order.destroy', ['id' => $order->id]) }}" method="post"
                                    onsubmit="return confirm('Are you sure you want to delete this orders?');">
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
                    Showing {{ $orders->firstItem() }} to {{ $orders->lastItem() }} of
                    {{ $orders->total() }}
                    entries
                </span>
            </div>

            <div class="flex items-center space-x-2">
                {{ $orders->links() }}
            </div>
        </div>
    </div>

    <script>
        document.getElementById('search').addEventListener('input', function() {
            const searchQuery = this.value.toLowerCase();
            history.pushState(null, null, `?search=${searchQuery}`);
            filterTableByUsername(searchQuery);
        });

        function filterTableByUsername(query) {
            const rows = document.querySelectorAll('#usersTable tbody tr');
            rows.forEach(row => {
                const cells = row.getElementsByTagName('td');
                const usernameCell = cells[1];

                if (usernameCell.textContent.toLowerCase().startsWith(query)) {
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
            filterTableByUsername(searchQuery);
        });
    </script>

    <script>
        function filterByStatus(status) {
            // Update the URL with the selected status
            const currentUrl = new URL(window.location.href);
            currentUrl.searchParams.set('status', status);
            window.location.href = currentUrl.toString(); // Redirect to the new URL
        }
    </script>
@endsection
