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
            <a href="{{ route('admin.order.index', ['status' => 'completed', 'entries' => request('entries')]) }}"
                class="border-2 {{ request('status') == 'completed' ? 'bg-green-500 text-white' : 'border-green-500 text-green-500' }} font-bold px-6 py-1 rounded-lg hover:bg-green-500 hover:text-white">
                Delivered
            </a>
            <a href="{{ route('admin.order.index', ['status' => 'declined', 'entries' => request('entries')]) }}"
                class="border-2 {{ request('status') == 'declined' ? 'bg-red-500 text-white' : 'border-red-500 text-red-500' }} font-bold px-6 py-1 rounded-lg hover:bg-red-500 hover:text-white">
                Rejected
            </a>
        </div>


        <div class="overflow-x-auto">
            <!-- Table Section -->
            <table id="orderTable" class="min-w-full border-separate border-spacing-0">
                <thead>
                    <tr class="bg-gray-100">
                        <th class="border border-gray-300 px-4 py-2">S.N</th>
                        <th class="border border-gray-300 px-4 py-2">Name</th>
                        <th class="border border-gray-300 px-4 py-2">Email</th>
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
                            <td class="border border-gray-300 px-4 py-2">{{ ucfirst($order->payment_method) }}</td>
                            <td class="border border-gray-300 px-4 py-2">€{{ number_format($order->total, 2) }}</td>
                            <td class="border border-gray-300 px-4 py-2">{{ $order->order_number }}</td>
                            <td class="border border-gray-300 px-4 py-2">{{ ucfirst($order->status) }}</td>
                            
                            
                            <td class="border border-gray-300 px-4 py-2">
                                <div class="flex justify-center gap-2">
                                <!-- View Icon -->
                                <a href="{{route('admin.order.view',$order->id)}}" class="bg-blue-500 hover:bg-blue-700 p-2 w-8 h-8 rounded-full flex items-center justify-center">
                                    <i class="ri-eye-line text-white"></i>
                                </a>
                                
                                @if($order->status == 'pending')
                                <!-- Right Icon -->
                                <a href="{{route('admin.order.complete',$order->id)}}" class="bg-green-500 hover:bg-green-700 p-2 w-8 h-8 rounded-full flex items-center justify-center">
                                    <i class="ri-check-line text-white"></i>
                                </a>
                                
                                <!-- Cross Icon -->
                                <a href="{{route('admin.order.reject',$order->id)}}" class="bg-gray-500 hover:bg-gray-700 p-2 w-8 h-8 rounded-full flex items-center justify-center">
                                    <i class="ri-close-line text-white"></i>
                                </a>
                                @endif
                                <!-- Delete Icon -->
                                <form action="{{ route('admin.order.destroy', ['id' => $order->id]) }}" method="post" onsubmit="return confirm('Are you sure you want to delete this order?');">
                                    @csrf
                                    @method('delete')
                                    <button class="bg-red-500 hover:bg-red-700 p-2 w-8 h-8 rounded-full flex items-center justify-center">
                                        <i class="ri-delete-bin-line text-white"></i>
                                    </button>
                                </form>
                            </div>
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
