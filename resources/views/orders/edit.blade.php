@extends('layouts.app')

@section('content')
<main class="flex-1 overflow-y-auto p-8 text-slate-800">
    
    <!-- 1. Breadcrumbs: Navigation path -->
    <nav class="flex text-sm text-slate-500 mb-4">
        <a href="#" class="hover:text-slate-800 transition">Dashboard</a>
        <span class="mx-2">/</span>
        <!-- Link back to the Orders list -->
        <a href="{{ route('orders.index') }}" class="hover:text-slate-800 transition">Orders</a>
        <span class="mx-2">/</span>
        <!-- Link back to the specific Order's detail page -->
        <a href="{{ route('orders.show', $order->id) }}" class="hover:text-slate-800 transition">Order #{{ $order->id }}</a>
        <span class="mx-2">/</span>
        <!-- Current Page -->
        <span class="text-slate-800 font-medium">Edit</span>
    </nav>

    <!-- 2. Header -->
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-slate-900">Edit order #{{ $order->id }}</h1>
        <p class="text-slate-500 mt-2">Update status and line items.</p>
    </div>

    <!-- 3. Main Form Area -->
    <!-- Form submits to the 'update' route using the PUT method (standard for updating data) -->
    <form action="{{ route('orders.update', $order->id) }}" method="POST" class="max-w-3xl">
        @csrf
        @method('PUT')
        
        <!-- Status Field -->
        <div class="mb-6">
            <label class="block text-sm font-medium text-slate-900 mb-2">Status</label>
            <select name="status" class="w-full rounded-md border border-slate-300 bg-white px-3 py-2.5 text-sm outline-none focus:border-slate-500 focus:ring-1 focus:ring-slate-500">
                @foreach($statuses as $key => $value)
                    <!-- Automatically select the current status of this order -->
                    <option value="{{ $key }}" {{ $order->status == $key ? 'selected' : '' }}>
                        {{ $value }}
                    </option>
                @endforeach
            </select>
        </div>

        <!-- Items Section -->
        <div class="mb-8">
            <div class="flex items-center justify-between mb-3">
                <label class="block text-sm font-medium text-slate-900">Items</label>
                <!-- Button to dynamically add a new item row via JavaScript -->
                <button type="button" id="add-item-btn" class="rounded-md border border-slate-300 bg-white px-4 py-1.5 text-sm font-medium text-slate-700 shadow-sm hover:bg-slate-50 transition">
                    Add Item
                </button>
            </div>

            <div id="items-container" class="space-y-3">
                
                <!-- ★ Loop through the existing items saved in this order ★ -->
                @foreach($order->items as $index => $orderItem)
                <div class="item-row flex gap-4 items-center bg-slate-50 p-3 rounded-lg border border-slate-200">
                    <div class="flex-1">
                        <!-- Use the loop index to create unique names (e.g., items[0][id], items[1][id]) -->
                        <select name="items[{{ $index }}][id]" class="item-select w-full rounded-md border border-slate-300 bg-white px-3 py-2.5 text-sm outline-none focus:border-slate-500">
                            <option value="">Select item</option>
                            @foreach($items as $item)
                                <!-- Automatically select the item if it matches the one saved in the order -->
                                <option value="{{ $item->id }}" {{ $orderItem->id == $item->id ? 'selected' : '' }}>
                                    {{ $item->name }} (${{ number_format($item->price, 2) }})
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="w-24">
                        <!-- Populate the quantity from the pivot table (order_items) -->
                        <input type="number" name="items[{{ $index }}][quantity]" value="{{ $orderItem->pivot->quantity }}" min="1" class="w-full rounded-md border border-slate-300 bg-white px-3 py-2.5 text-sm outline-none focus:border-slate-500 text-center">
                    </div>
                    <div>
                        <button type="button" class="remove-btn rounded-md border border-slate-300 bg-white px-4 py-2.5 text-sm font-medium text-slate-500 hover:bg-slate-50 hover:text-slate-700 transition">
                            Remove
                        </button>
                    </div>
                </div>
                @endforeach
                
            </div>
        </div>

        <!-- Form Actions -->
        <div class="flex items-center gap-4 mt-8">
            <button type="submit" class="bg-slate-900 hover:bg-slate-800 text-white px-5 py-2.5 rounded-md text-sm font-medium transition shadow-sm">
                Update order
            </button>
            <!-- Cancel button returns to the order detail page -->
            <a href="/order" class="text-sm font-medium text-slate-500 hover:text-slate-800 transition">Cancel</a>
        </div>
    </form>
</main>

<!-- HTML Template for a new item row (used by JavaScript to clone new rows) -->
<template id="item-row-template">
    <div class="item-row flex gap-4 items-center bg-slate-50 p-3 rounded-lg border border-slate-200 mt-3">
        <div class="flex-1">
            <!-- __INDEX__ is a placeholder that JavaScript will replace with a unique number -->
            <select name="items[__INDEX__][id]" class="item-select w-full rounded-md border border-slate-300 bg-white px-3 py-2.5 text-sm outline-none focus:border-slate-500">
                <option value="">Select item</option>
                @foreach($items as $item)
                    <option value="{{ $item->id }}">{{ $item->name }} (${{ number_format($item->price, 2) }})</option>
                @endforeach
            </select>
        </div>
        <div class="w-24">
            <input type="number" name="items[__INDEX__][quantity]" value="1" min="1" class="w-full rounded-md border border-slate-300 bg-white px-3 py-2.5 text-sm outline-none focus:border-slate-500 text-center">
        </div>
        <div>
            <button type="button" class="remove-btn rounded-md border border-slate-300 bg-white px-4 py-2.5 text-sm font-medium text-slate-500 hover:bg-slate-50 hover:text-slate-700 transition">
                Remove
            </button>
        </div>
    </div>
</template>

<!-- JavaScript for Add/Remove functionality and preventing duplicate selections -->
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const container = document.getElementById('items-container');
        const addBtn = document.getElementById('add-item-btn');
        const template = document.getElementById('item-row-template');
        
        // Get the current number of items to ensure the new row index doesn't clash
        let itemIndex = {{ $order->items->count() }}; 

        // Add a new row when "Add Item" is clicked
        addBtn.addEventListener('click', function() {
            const newRowHtml = template.innerHTML;
            // Replace the placeholder with the current index
            const finalHtml = newRowHtml.replace(/__INDEX__/g, itemIndex);
            container.insertAdjacentHTML('beforeend', finalHtml);
            itemIndex++;
            updateDropdowns(); // Check for duplicate selections
        });

        // Remove a row when "Remove" is clicked
        container.addEventListener('click', function(e) {
            if (e.target.classList.contains('remove-btn')) {
                e.target.closest('.item-row').remove();
                updateDropdowns(); // Re-check remaining dropdowns
            }
        });

        // Listen for changes in any dropdown to update the options
        container.addEventListener('change', function(e) {
            if (e.target.classList.contains('item-select')) {
                updateDropdowns();
            }
        });

        // Function to hide/disable items that have already been selected in other rows
        function updateDropdowns() {
            const selects = document.querySelectorAll('.item-select');
            // Get all currently selected values
            const selectedValues = Array.from(selects).map(select => select.value).filter(value => value !== "");

            selects.forEach(select => {
                const currentValue = select.value;
                Array.from(select.options).forEach(option => {
                    if (option.value === "") return; // Ignore the default "Select item" option
                    
                    // If this option is selected in another dropdown, hide and disable it here
                    if (selectedValues.includes(option.value) && option.value !== currentValue) {
                        option.hidden = true; 
                        option.disabled = true; 
                    } else {
                        // Otherwise, make sure it's visible and enabled
                        option.hidden = false; 
                        option.disabled = false;
                    }
                });
            });
        }
        
        // Run the check on page load to prevent duplicates if the DB has issues
        updateDropdowns();
    });
</script>
@endsection