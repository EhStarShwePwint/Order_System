@extends('layouts.app')

@section('content')
<main class="flex-1 overflow-y-auto p-8 text-slate-800">
    
    <!-- 1. Breadcrumbs: Navigation path to show current location -->
    <nav class="flex text-sm text-slate-500 mb-4">
        <a href="#" class="hover:text-slate-800 transition">Dashboard</a>
        <span class="mx-2">/</span>
        <!-- Link back to the main orders list -->
        <a href="{{ route('orders.index') }}" class="hover:text-slate-800 transition">Orders</a>
        <span class="mx-2">/</span>
        <!-- Current Page -->
        <span class="text-slate-800 font-medium">Order #{{ $order->id }}</span>
    </nav>

    <!-- 2. Header: Order Details & Action Buttons -->
    <div class="flex items-start justify-between mb-8">
        <div>
            <!-- Order ID Title -->
            <h1 class="text-3xl font-bold text-slate-900">Order #{{ $order->id }}</h1>
            
            <!-- Order Status and Total Price -->
            <p class="text-slate-500 mt-2">
                Status: <span class="capitalize font-medium">{{ $order->status }}</span> 
                &middot; <!-- Middle dot separator -->
                Total: ${{ number_format($order->total, 2) }}
            </p>
        </div>
        
        <!-- Action Buttons (Edit and Delete) -->
        <div class="flex gap-3">
            <!-- Edit Button (Link to edit page) -->
            <a href="/orders/{{$order->id}}/edit" class="rounded-md border border-slate-300 bg-white px-4 py-2 text-sm font-medium text-slate-700 shadow-sm hover:bg-slate-50 transition">
                Edit
            </a>
            
            <!-- Delete Button (Using a form to send a DELETE request) -->
            <form action="#" method="POST" class="inline-block">
                @csrf
                @method('DELETE')
                <button type="submit" class="rounded-md border border-red-200 bg-white px-4 py-2 text-sm font-medium text-red-600 shadow-sm hover:bg-red-50 transition">
                    Delete
                </button>
            </form>
        </div>
    </div>

    <!-- 3. Line Items Section -->
    <div class="mb-4">
        <h2 class="text-lg font-bold text-slate-900">Line items</h2>
    </div>

    <!-- Table Container -->
    <div class="bg-white border border-slate-200 rounded-xl overflow-hidden shadow-sm">
        <table class="w-full text-left text-sm text-slate-600">
            <!-- Table Head: Column Names -->
            <thead class="bg-slate-50 border-b border-slate-200 text-slate-900">
                <tr>
                    <th class="px-6 py-4 font-semibold w-2/5">Item</th>
                    <th class="px-6 py-4 font-semibold w-1/5">Qty</th>
                    <th class="px-6 py-4 font-semibold w-1/5">Unit price</th>
                    <th class="px-6 py-4 font-semibold w-1/5">Subtotal</th>
                </tr>
            </thead>
            
            <!-- Table Body: Looping through Order Items -->
            <tbody class="divide-y divide-slate-100">
                
                <!-- Start of Loop: Iterate over each item in this order -->
                @foreach($order->items as $item)
                <tr class="hover:bg-slate-50 transition">
                    <!-- Item Name -->
                    <td class="px-6 py-4 font-medium text-slate-900">{{ $item->name }}</td>
                    
                    <!-- Quantity (Retrieved from the pivot table: order_items) -->
                    <td class="px-6 py-4">{{ $item->pivot->quantity }}</td>
                    
                    <!-- Unit Price at the time of order (Retrieved from the pivot table) -->
                    <td class="px-6 py-4">${{ number_format($item->pivot->unit_price, 2) }}</td>
                    
                    <!-- Subtotal Calculation: Quantity * Unit Price -->
                    <td class="px-6 py-4">
                        ${{ number_format($item->pivot->quantity * $item->pivot->unit_price, 2) }}
                    </td>
                </tr>
                @endforeach
                <!-- End of Loop -->
                
            </tbody>
        </table>
    </div>
    
</main>
@endsection