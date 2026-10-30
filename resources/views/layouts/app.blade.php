<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Dashboard Layout</title>
  <script src="https://cdn.tailwindcss.com"></script>
  {{-- JavaScript to Auto-Hide Alerts --}}
  <script>
      document.addEventListener('DOMContentLoaded', function() {
          // Find the alert element by its ID
          const alert = document.getElementById('auto-hide-alert');
          
          // If the alert exists on the page, hide it after 3 seconds (3000 milliseconds)
          if (alert) {
              setTimeout(function() {
                  // Add Tailwind classes for a fade-out transition
                  alert.style.transition = 'opacity 0.5s ease-out';
                  alert.style.opacity = '0';
                  
                  // Wait for the fade-out animation to finish (500ms), then remove the element from the DOM
                  setTimeout(function() {
                      alert.remove();
                  }, 500); 
                  
              }, 3000); // 3 seconds delay
          }
      });
  </script>
</head>
<body class="bg-slate-100">

  <div class="flex h-screen overflow-hidden">

    <!-- SIDEBAR -->
    <aside class="w-64 bg-white border-r border-slate-200 flex flex-col">
      
      <!-- Logo Section -->
      <div class="h-16 flex items-center border-b border-slate-200">
        <!-- Logo wrapped in a link. Clicking it always returns the user to the dashboard. -->
        <!-- The hover effect here changes the background slightly to show it is clickable. -->
        <a href="{{ url('/dashboard') }}" class="flex items-center h-full px-6 w-full hover:bg-slate-50 transition">
          <span class="text-xl font-bold text-blue-600 tracking-wide">MyApp</span>
        </a>
      </div>

      <!-- Navigation Links -->
      <nav class="flex-1 px-3 py-4 space-y-1 overflow-y-auto">
        
        <!-- 1. Orders Link -->
        <!-- We use a Ternary Operator ( ? : ) to check the current URL. -->
        <!-- If the current URL is '/orderPage', it applies the Active state classes (bg-blue-50 text-blue-600). -->
        <!-- If the current URL is anything else, it applies the Inactive state classes (text-slate-500) and sets up the hover effect. -->
        <a href="/order" 
          class="flex items-center gap-3 px-4 py-3 rounded-lg transition
                  {{ request()->is('order') || request()->is('orders*')
                      ? 'bg-blue-50 text-blue-600 font-medium' 
                      : 'text-slate-500 hover:bg-slate-50 hover:text-blue-600' }}">
          <!-- Order/Box Icon -->
          <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>
          </svg>
          <span>Orders</span>
        </a>

        <!-- 2. Items Link -->
        <!-- Same logic here: It checks if the current URL is '/itemPage'. -->
        <!-- If true, it highlights the link (Active). If false, it stays gray but turns blue on hover. -->
        <a href="/item" 
          class="flex items-center gap-3 px-4 py-3 rounded-lg transition
                  {{ request()->is('items*')||request()->is('item')
                      ? 'bg-blue-50 text-blue-600 font-medium' 
                      : 'text-slate-500 hover:bg-slate-50 hover:text-blue-600' }}">
          <!-- Items/Package Icon -->
          <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
          </svg>
          <span>Items</span>
        </a>

      </nav>
    </aside>

    <!-- MAIN AREA -->
    <div class="flex-1 flex flex-col overflow-hidden">

      <!-- Top Navbar Container -->
        <nav class="h-16 bg-white border-b border-slate-200 flex items-center justify-end px-6">
        
        <!-- User Dropdown Wrapper -->
        <div class="relative group">
            
            <!-- Trigger Button (susu text with arrow) -->
            <button class="flex items-center gap-2 py-2 px-3 rounded-lg hover:bg-slate-50 text-slate-700 transition">
            <span class="text-sm font-medium">{{ Auth::user()->name }}</span>
            <svg class="w-4 h-4 text-slate-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"/>
            </svg>
            </button>

            <!-- Dropdown Menu -->
            <div class="absolute right-0 top-full mt-1 w-48 bg-white rounded-lg shadow-lg border border-slate-200 opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-200 z-50">
            <div class="py-1">
                <a href="/profile" class="block px-4 py-2 text-sm text-slate-700 hover:bg-slate-50">Profile</a>
            </div>
            <div class="border-t border-slate-100 py-1">
                <!-- Logout button matching your image style -->
                <form method="POST" action="/logout">
                @csrf
                <button type="submit" class="block w-full text-left px-4 py-2 text-sm text-red-600 hover:bg-red-50">Log out</button>
                </form>
            </div>
            </div>
            
        </div>
        </nav>
    

        <!-- MAIN CONTENT -->
        <main class="flex-1 overflow-y-auto p-6">
          
            {{-- Success Alert --}}
            {{-- Checks if a session variable named 'success' exists --}}
            @if (session('success'))
                <!-- Green alert box for success messages. Added id for JavaScript -->
                <div id="auto-hide-alert" class="mb-4 rounded-lg border border-green-300 bg-green-50 px-4 py-3 text-green-700">
                    {{ session('success') }}
                </div>
            @endif

            {{-- Error Alert --}}
            {{-- Checks if a session variable named 'error' exists --}}
            @if (session('error'))
                <!-- Red alert box for general error messages. Added id for JavaScript -->
                <div id="auto-hide-alert" class="mb-4 rounded-lg border border-red-300 bg-red-50 px-4 py-3 text-red-700">
                    {{ session('error') }}
                </div>
            @endif

            {{-- Validation Errors --}}
            {{-- Checks if there are any validation errors (e.g., form field empty) --}}
            @if ($errors->any())
                <!-- Red alert box containing a list of all validation errors -->
                <div class="mb-4 rounded-lg border border-red-300 bg-red-50 px-4 py-3 text-red-700">
                    <p class="font-semibold">Please fix the following errors:</p>

                    <!-- Unordered list to display each error message -->
                    <ul class="mt-2 list-disc pl-5">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif


            @yield('content')
        </main>
    </div>
  </div>

</body>
</html>
