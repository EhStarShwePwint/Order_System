@extends('layouts.app')
@section('content')
<main class="flex-1 overflow-y-auto p-8">
    <!-- Top Small Heading -->
    <h2 class="text-sm font-semibold text-gray-800 mb-6">Dashboard</h2>

    <!-- Main Title -->
    <h1 class="text-3xl font-bold text-gray-900 mb-4">Dashboard</h1>

    <!-- Welcome Message -->
    <p class="text-gray-600 mb-8">
        Welcome back, susu. Use the sidebar to manage Orders and Items.
    </p>

    <!-- Buttons Container -->
    <div class="flex flex-wrap gap-4">
        
        <!-- Go to Orders Button -->
        <a href="/order" class="px-5 py-2.5 bg-white border border-gray-300 rounded-md text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-300 transition-colors">
            Go to Orders
        </a>

        <!-- Go to Items Button -->
        <a href="/item" class="px-5 py-2.5 bg-white border border-gray-300 rounded-md text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-300 transition-colors">
            Go to Items
        </a>
        
    </div>

</main>
@endsection