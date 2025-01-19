<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Admin Panel</title>
  <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@100;300;400;600;700&display=swap" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/remixicon@2.5.0/fonts/remixicon.css" rel="stylesheet">
  @vite(['resources/css/app.css', 'resources/js/app.js'])
  <script>
    // Remove the JavaScript related to toggling the sidebar
    window.onload = function () {
      const sidebar = document.getElementById('sidebar');
      const content = document.getElementById('content-container');

      // Make sure the sidebar is always in expanded state
    };
  </script>
  
  <script>
    // Function to update entries based on user selection
    function updateEntries() {
        const entries = document.getElementById('entries').value; // Get selected value
        const url = new URL(window.location.href);
        url.searchParams.set('entries', entries);
        window.location.href = url; 
    }
</script>

</head>

<body class="bg-gray-100 text-gray-900 h-screen flex flex-col font-[Jost]">

  <div class="flex h-full">
    <!-- Sidebar -->
    <aside id="sidebar" class="w-64 bg-white text-gray-900 shadow-lg flex flex-col fixed top-0 bottom-0 left-0 transition-all duration-300 overflow-y-auto z-10">
      <div class="p-4 flex items-center justify-center bg-white">
        <img id="logo" src="{{ asset('images/logo.jpg') }}" alt="Logo" class="w-32 h-32 rounded-full border-2 border-gray-500 object-contain">
      </div>
      <nav class="mt-6">
        <a href="{{ route('admin.dashboard') }}" class="sidebar-link flex items-center px-6 py-4 {{ request()->routeIs('admin.dashboard') ? 'bg-blue-600 text-white' : 'hover:bg-blue-500 hover:text-white' }} transition-colors duration-200">
          <i class="ri-layout-masonry-fill"></i>
          <span class="ml-4 font-semibold">Dashboard</span>
        </a>
        <a href="{{route('admin.category.index')}}" class="sidebar-link flex items-center px-6 py-4 {{ request()->routeIs('admin.category.index') ? 'bg-blue-600 text-white' : 'hover:bg-blue-500 hover:text-white' }} transition-colors duration-200">
          <i class="ri-grid-line"></i>
          <span class="ml-4 font-semibold">Category</span>
        </a>
        <a href="{{route('admin.fooditems.index')}}" class="sidebar-link flex items-center px-6 py-4 {{ request()->routeIs('admin.fooditems.index') ? 'bg-blue-600 text-white' : 'hover:bg-blue-500 hover:text-white' }} transition-colors duration-200">
            <i class="ri-cup-line"></i>
          <span class="ml-4 font-semibold">Food Items</span>
        </a>
        <a href="{{route('admin.booking.index')}}" class="sidebar-link flex items-center px-6 py-4 {{ request()->routeIs('admin.booking.index') ? 'bg-blue-600 text-white' : 'hover:bg-blue-500 hover:text-white' }} transition-colors duration-200">
            <i class="ri-calendar-check-fill"></i>
            <span class="ml-4 font-semibold">Reservations</span>
          </a>
        <a href="{{route('admin.order.index')}}" class="sidebar-link flex items-center px-6 py-4 {{ request()->routeIs('admin.order.index') ? 'bg-blue-600 text-white' : 'hover:bg-blue-500 hover:text-white' }} transition-colors duration-200">
          <i class="ri-shopping-cart-2-fill"></i>
          <span class="ml-4 font-semibold">Orders</span>
        </a>
        <a href="{{route('admin.banner.index')}}" class="sidebar-link flex items-center px-6 py-4 {{ request()->routeIs('admin.banner.index') ? 'bg-blue-600 text-white' : 'hover:bg-blue-500 hover:text-white' }} transition-colors duration-200">
          <i class="ri-image-fill"></i>
          <span class="ml-4 font-semibold">Banners</span>
        </a>

      </nav>
    </aside>

      <!-- Main Content -->
      <main class="ml-64 w-full">
        <!-- Header Section -->
      <div class="w-full bg-red-600 text-white flex items-center justify-between px-4 py-14 shadow-lg">
        <h1 class="text-xl font-semibold">{{ $title ?? 'Default Title' }}</h1>
        <div class="flex items-center space-x-4">
          <div class="relative group">
            <div class="flex items-center text-lg font-medium hover:text-white focus:outline-none cursor-pointer">
              <!-- Display the logged-in user's name -->
              <span>{{ Auth::user()->name }}</span>
              <i class="ri-arrow-down-s-line text-white"></i>
            </div>
  
            <!-- Dropdown Menu -->
            <div class="absolute right-0 w-40 bg-white text-gray-800 rounded-md shadow-lg hidden group-hover:block z-[50]">
              <a href="#" class="block px-4 py-2 text-sm hover:bg-gray-100">Profile</a>
              <form action="{{ route('logout') }}" method="POST" class="w-full">
                @csrf
                <button type="submit" class="block w-full text-left px-4 py-2 text-sm hover:bg-gray-100">
                  Log Out
                </button>
              </form>
            </div>
          </div>
  
          <div>
            <button class="hover:bg-red-500 transition ease-in-out duration-200">
              <i class="ri-moon-fill"></i>
            </button>
          </div>
        </div>
      </div>
       <div class="pb-6">
        @yield('content')
       </div>
    </main>
    
  
    </div>
  
  </body>
  
  </html>