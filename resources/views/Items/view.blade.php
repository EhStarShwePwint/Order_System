@extends('layouts.app')

@section('content')
<main class="flex-1 overflow-y-auto p-8 text-slate-800">
    
    <!-- 1. Breadcrumbs -->
    <nav class="flex text-sm text-slate-500 mb-4">
        <a href="{{ url('/dashboard') }}" class="hover:text-blue-600 transition">Dashboard</a>
        <span class="mx-2">/</span>
        <a href="{{ url('/items') }}" class="hover:text-blue-600 transition">Items</a>
        <span class="mx-2">/</span>
        <span class="text-slate-800 font-medium">{{$item->name}}</span> 
    </nav>

    <!-- 2. Header Section (Title, Price, and Buttons) -->
    <div class="flex items-start justify-between mb-8">
        <div>
            <!-- Item Name -->
            <h1 class="text-3xl font-bold text-slate-900">{{ $item->name }}</h1>
            <!-- Item Price formatted with commas -->
            <p class="text-slate-500 mt-2">${{ number_format($item->price, 2)}}</p>
        </div>
        
        <!-- Action Buttons -->
        <div class="flex gap-3">
            <!-- Edit Button -->
            <a href="/items/{{ $item->id }}/edit" class="px-4 py-2 border border-slate-200 rounded-lg text-sm font-medium text-slate-700 bg-white hover:bg-slate-50 hover:text-blue-600 transition shadow-sm">
                Edit
            </a>
            
            <!-- Delete Button -->
            <form action="{{ url('/item/' . $item->id . '/delete') }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this item?')">
                @csrf
                @method('DELETE')
                <button type="submit" class="inline-flex items-center rounded-lg border border-red-200 bg-white px-4 py-2 text-sm font-medium text-red-600 shadow-sm transition hover:bg-red-50">
                    Delete
                </button>
            </form>
        </div>
    </div>

    <!-- 3. Description Text -->
    <div class="mb-10">
        <p class="text-slate-500 text-sm">{{ $item->description ?? 'No description provided.' }}</p>
    </div>

    <!-- 4. Related Orders Section -->
    <div class="mb-4">
        <h2 class="text-lg font-bold text-slate-900">Related orders</h2>
    </div>

    <!-- Related Orders Table -->
    <div class="bg-white border border-slate-200 rounded-xl overflow-hidden shadow-sm">
        <table class="w-full text-left text-sm text-slate-600">
            <!-- Table Head -->
            <thead class="bg-slate-50 border-b border-slate-200 text-slate-800">
                <tr>
                    <th class="px-6 py-4 font-semibold w-1/4">Order</th>
                    <th class="px-6 py-4 font-semibold w-1/3">Customer</th>
                    <th class="px-6 py-4 font-semibold w-1/6">Qty</th>
                    <th class="px-6 py-4 font-semibold w-1/4">Unit price</th>
                </tr>
            </thead>
            <!-- Table Body -->
            <tbody class="divide-y divide-slate-100">
                
                @forelse($item->orders as $order)
                <tr class="hover:bg-slate-50 transition">
                    
                    <!-- Order ID (Clickable link to go to Order View Page) -->
                    <td class="px-6 py-4 font-medium">
                        <a href="" class="text-blue-600 hover:underline">
                            #{{ $order->id }}
                        </a>
                    </td>
                    
                    <!-- Customer Name (Relation ) -->
                    <td class="px-6 py-4 text-slate-800">{{ $order->user->name ?? 'Unknown' }}</td>
                    
                    <!-- Quantity (Pivot Table) -->
                    <td class="px-6 py-4">{{ $order->pivot->quantity }}</td>
                    
                    <!-- Unit price (Pivot Table) -->
                    <td class="px-6 py-4">${{ number_format($order->pivot->unit_price, 2) }}</td>
                    
                </tr>
                @empty
                <tr>
                    <td colspan="4" class="px-6 py-8 text-center text-slate-500">
                        This item has not been ordered yet.
                    </td>
                </tr>
                @endforelse

            </tbody>
        </table>
    </div>

</main>
@endsection