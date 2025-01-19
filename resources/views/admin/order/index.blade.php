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


        <div class="overflow-x-auto">
            <!-- Table Section -->
            <table id="orderTable" class="min-w-full border-separate border-spacing-0 border border-gray-300">
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
                        <th class="border border-gray-300 px-4 py-2">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($orders as $order)
                        <tr class="bg-white hover:bg-gray-50">
                            <td class="border border-gray-300 px-4 py-2 text-center">{{ $loop->iteration }}</td>
                            <td class="border border-gray-300 px-4 py-2">{{ $order->name }}</td>
                            <td class="border border-gray-300 px-4 py-2">{{ $order->email }}</td>
                            <td class="border border-gray-300 px-4 py-2">{{ $order->phone }}</td>
                            <td class="border border-gray-300 px-4 py-2">{{ ucfirst($order->payment_method) }}</td>
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
                                                <td class="border border-gray-300 px-4 py-2">${{ number_format($item['price'], 2) }}</td>
                                                <td class="border border-gray-300 px-4 py-2">{{ $item['description'] }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </td> --}}
            
                            <td class="px-2 py-2 flex justify-center space-x-4">
                                <!-- Delete Icon -->
                                <form action="{{ route('admin.order.destroy', ['id' => $order->id]) }}" method="post" onsubmit="return confirm('Are you sure you want to delete this order?');">
                                    @csrf
                                    @method('delete')
                                    <button class="bg-red-500 hover:bg-red-700 p-2 w-10 h-10 rounded-full flex items-center justify-center border-none outline-none focus:ring-0">
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
        function filterByStatus(status) {
            // Update the URL with the selected status
            const currentUrl = new URL(window.location.href);
            currentUrl.searchParams.set('status', status);
            window.location.href = currentUrl.toString(); // Redirect to the new URL
        }
    </script>

<script>
    $(document).ready(function () {
        $('#orderTable').DataTable({
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
