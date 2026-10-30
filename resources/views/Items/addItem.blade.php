@extends('layouts.app')

@section('content')
<main class="flex-1 overflow-y-auto p-8">
    
    <!-- 1. Breadcrumbs -->
    <nav class="flex text-sm text-slate-500 mb-4">
        <a href="{{ url('/dashboard') }}" class="hover:text-blue-600">Dashboard</a>
        <span class="mx-2">/</span>
        <a href="{{ url('/items') }}" class="hover:text-blue-600">Items</a>
        <span class="mx-2">/</span>
        <span class="text-slate-800 font-medium">Create</span>
    </nav>

    <!-- 2. Page Header -->
    <div class="mb-8">
        <h1 class="text-2xl font-bold text-slate-900">New item</h1>
        <p class="text-sm text-slate-500 mt-1">Add a product to the catalog.</p>
    </div>

    <!-- 3. Form Section -->
    <!-- Note: Replace the action route with your actual route to store the item -->
    <form action="{{ url('/saveItem') }}" method="POST" class="max-w-2xl">
        @csrf
        
        <!-- Name Field -->
        <div class="mb-6">
            <label for="name" class="block text-sm font-medium text-slate-800 mb-2">Name</label>
            <input type="text" name="name" value="{{ old('name') }}" id="name" 
                   class="w-full px-4 py-2.5 border border-slate-200 rounded-lg text-sm text-slate-700 focus:outline-none focus:ring-2 focus:ring-blue-600 focus:border-transparent transition">
            <!-- Error Message Example (Optional) -->
            @error('name')
                <span class="text-red-500 text-xs mt-1">{{ $message }}</span>
            @enderror
        </div>

        <!-- Description Field -->
        <div class="mb-6">
            <label for="description" class="block text-sm font-medium text-slate-800 mb-2">Description</label>
            <textarea name="description" value="{{ old('description') }}" id="description" rows="5" 
                      class="w-full px-4 py-3 border border-slate-200 rounded-lg text-sm text-slate-700 focus:outline-none focus:ring-2 focus:ring-blue-600 focus:border-transparent transition resize-y"></textarea>
        </div>

        <!-- Price Field -->
        <div class="mb-8">
            <label for="price" class="block text-sm font-medium text-slate-800 mb-2">Price</label>
            <input type="number" step="0.01" name="price" value="{{ old('price') }}" id="price" 
                   class="w-full px-4 py-2.5 border border-slate-200 rounded-lg text-sm text-slate-700 focus:outline-none focus:ring-2 focus:ring-blue-600 focus:border-transparent transition">
            @error('price')
                <span class="text-red-500 text-xs mt-1">{{ $message }}</span>
            @enderror
        </div>
        

        <!-- Action Buttons -->
        <div class="flex items-center gap-4">
            <!-- Create Button (Blue) -->
            <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-5 py-2.5 rounded-lg text-sm font-medium transition shadow-sm">
                Create item
            </button>
            
            <!-- If you want the black button from the image, use this instead:
            <button type="submit" class="bg-slate-900 hover:bg-slate-800 text-white px-5 py-2.5 rounded-lg text-sm font-medium transition shadow-sm">
                Create item
            </button> -->

            <!-- Cancel Button -->
            <a href="/item" class="text-sm font-medium text-slate-400 hover:text-slate-700 transition">
                Cancel
            </a>
        </div>
    </form>

</main>
@endsection
