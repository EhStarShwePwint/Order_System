@extends('layouts.app')

@section('content')
<main class="flex-1 overflow-y-auto p-8">
    
    <!-- 1. Breadcrumbs: Navigation path -->
    <nav class="flex text-sm text-slate-500 mb-4">
        <a href="#" class="hover:text-blue-600">Dashboard</a>
        <span class="mx-2">/</span>
        <span class="text-slate-800 font-medium">Orders</span>
    </nav>

    <!-- 2. Header: Page title and "New Order" button -->
    <div class="flex items-center justify-between mb-8">
        <div>
            <h1 class="text-2xl font-bold text-slate-900">Orders</h1>
            <p class="text-sm text-slate-500 mt-1">Your orders and their line items.</p>
        </div>
        <!-- Link to create a new order page -->
        <a href="{{ url('/orders/createPage') }}" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg text-sm font-medium flex items-center gap-2 transition shadow-sm inline-flex">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/>
            </svg>
            New order
        </a>
    </div>

        <!-- 3. Search Bar: UI only (Logic needs to be added later) -->
        <!-- 3. Search Bar -->
        <!-- Use GET method so the search term appears in the URL -->
        <form action="{{ route('orders.index') }}" method="GET" class="mb-6 flex gap-3">
            
            <!-- Search Input -->
            <input
                type="text"
                name="search"
                value="{{ $search }}" {{-- Retain the search term in the input box --}}
                placeholder="Search orders by ID, status, or item name..."
                class="w-full rounded-xl border border-slate-200 bg-white px-4 py-3 outline-none focus:border-blue-500 text-sm"
            >
            
            <!-- Search Button -->
            <button type="submit" class="rounded-xl border border-slate-200 bg-white px-8 py-3 hover:bg-slate-50 text-sm font-medium text-slate-700 transition-colors">
                Search
            </button>
            
            <!-- Clear/Reset Button (Only shows if there is an active search) -->
            @if($search)
                <a href="{{ route('orders.index') }}" class="rounded-xl border border-red-200 bg-red-50 px-6 py-3 hover:bg-red-100 text-sm font-medium text-red-600 transition-colors flex items-center justify-center">
                    Clear
                </a>
            @endif
        </form>

    <!-- 4. Data Table: Displaying orders from the database -->
    <div class="bg-white border border-slate-200 rounded-xl overflow-hidden shadow-sm">
        <table class="w-full text-left text-sm text-slate-600">
            <!-- Table Head: Columns -->
            <thead class="bg-slate-50 border-b border-slate-200 text-slate-900">
                <tr>
                    <th class="px-6 py-5 font-semibold w-1/3">Order</th>
                    <th class="px-6 py-5 font-semibold w-1/4">Status</th>
                    <th class="px-6 py-5 font-semibold w-1/4">Items</th>
                    <th class="px-6 py-5 font-semibold w-1/4">Total</th>
                    <th class="px-6 py-5 font-semibold text-right">Actions</th>
                </tr>
            </thead>
            <!-- Table Body: Looping through orders -->
            <tbody class="divide-y divide-slate-100">
                
                <!-- Start of Loop: Iterate over each order passed from the controller -->
                @forelse($orders as $order)
                <tr class="hover:bg-slate-50 transition">
                    <!-- Order ID -->
                    <td class="px-6 py-5 font-medium text-slate-900">#{{ $order->id }}</td>
                    
                    <!-- Order Status (capitalized first letter) -->
                    <td class="px-6 py-5 capitalize">{{ $order->status }}</td>
                    
                    <!-- Number of Items in this order (Using relationship count) -->
                    <td class="px-6 py-5">{{ $order->items->count() }}</td>
                    
                    <!-- Total Price (Formatted with commas and 2 decimals) -->
                    <td class="px-6 py-5">${{ number_format($order->total, 2) }}</td>
                    
                    <!-- Action Buttons: View, Edit, Delete -->
                    <td class="px-6 py-5 flex justify-end gap-3">
                        <!-- View Button -->
                        <a href="{{ route('orders.show', $order->id) }}" class="inline-flex items-center gap-1.5 rounded-lg border border-slate-200 px-3 py-1.5 text-slate-700 transition hover:bg-slate-50">
                            <svg class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                            </svg>
                            View
                        </a>
                        
                        <!-- Edit Button -->
                        <a href="/orders/{{$order->id}}/edit" class="inline-flex items-center gap-1.5 rounded-lg border border-slate-200 px-3 py-1.5 text-slate-700 transition hover:bg-slate-50">
                            <svg class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/>
                            </svg>
                            Edit
                        </a>
                        
                        <!-- Delete Form -->
                        <form action="{{ route('orders.destroy', $order->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Are you sure you want to delete this order?');">
                            @csrf
                            @method('DELETE')
                            
                            <!-- The actual Delete button with Tailwind styling (red theme) -->
                            <button type="submit" class="inline-flex items-center gap-1.5 rounded-lg border border-red-200 px-3 py-1.5 text-red-600 transition hover:bg-red-50">
                                
                                <!-- Trash Can Icon (SVG) -->
                                <svg class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                </svg>
                                
                                <!-- Button Text -->
                                Delete
                            </button>
                        </form>
                    </td>
                </tr>
                @empty
                <!-- If there are no orders in the database, show this message -->
                <tr>
                    <td colspan="5" class="px-6 py-8 text-center text-slate-500">
                        No orders found. Create a new order to get started.
                    </td>
                </tr>
                @endforelse
                <!-- End of Loop -->

            </tbody>
        </table>
    </div>
</main>
@endsection