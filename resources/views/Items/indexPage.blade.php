@extends('layouts.app') <!-- Make sure this matches your layout file name -->

@section('content')
<main class="flex-1 overflow-y-auto p-8">
    
    <!-- 1. Breadcrumbs -->
    <nav class="flex text-sm text-slate-500 mb-4">
        <a href="#" class="hover:text-blue-600">Dashboard</a>
        <span class="mx-2">/</span>
        <span class="text-slate-800 font-medium">Items</span>
    </nav>

    <!-- 2. Header (Title + New Item Button) -->
    <div class="flex items-center justify-between mb-8">
        <div>
            <h1 class="text-2xl font-bold text-slate-900">Items</h1>
            <p class="text-sm text-slate-500 mt-1">Manage catalog items used in orders.</p>
        </div>
        <a href="{{ url('/items/createPage') }}" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg text-sm font-medium flex items-center gap-2 transition shadow-sm inline-flex">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/>
            </svg>
            New item
        </a>
    </div>

    <form action="{{ url('/item') }}" method="GET"
      class="mb-6 flex gap-3">

    <input
        type="text"
        name="search"
        value="{{ $search }}"
        placeholder="Search items by name or description..."
        class="w-full rounded-xl border border-slate-200
               bg-white px-4 py-3 outline-none
               focus:border-blue-500"
    >

    <button type="submit"
            class="rounded-xl border border-slate-200
                   bg-white px-6 py-3 hover:bg-slate-50">
        Search
    </button>

    @if ($search)
    <a href="{{ url('/item') }}"
       class="inline-flex items-center justify-center gap-2
              rounded-xl border border-slate-200
              bg-white px-5 py-3 text-sm font-medium
              text-slate-600 shadow-sm
              transition duration-200
              hover:border-red-200 hover:bg-red-50
              hover:text-red-600
              focus:outline-none focus:ring-2
              focus:ring-red-200">

        <svg xmlns="http://www.w3.org/2000/svg"
             width="18" height="18"
             viewBox="0 0 24 24"
             fill="none"
             stroke="currentColor"
             stroke-width="2"
             stroke-linecap="round"
             stroke-linejoin="round">
            <path d="M3 12a9 9 0 1 0 2.6-6.4L3 8"></path>
            <path d="M3 3v5h5"></path>
        </svg>

        <span>Reset</span>
    </a>
@endif
    </form>

    <!-- 4. Data Table -->
    <div class="bg-white border border-slate-200 rounded-xl overflow-hidden">
        <table class="w-full text-left text-sm text-slate-600">
            <!-- Table Head -->
            <thead class="bg-slate-50 border-b border-slate-200 text-slate-900">
                <tr>
                    <th class="px-6 py-4 font-semibold w-1/3">Name</th>
                    <th class="px-6 py-4 font-semibold w-1/4">Price</th>
                    <th class="px-6 py-4 font-semibold w-1/4">Orders</th>
                    <th class="px-6 py-4 font-semibold text-right">Actions</th>
                </tr>
            </thead>
            <!-- Table Body -->
            <tbody class="divide-y divide-slate-100">
                
               @foreach($items as $item)
                <tr class="hover:bg-slate-50 transition">
                    <td class="px-6 py-4 font-medium text-slate-900">{{$item->name}}</td>
                    <td class="px-6 py-4">${{$item->price}}</td>
                    <td class="px-6 py-4">2</td>
                    <td class="px-6 py-4 flex justify-end gap-2">
                        <a href="/items/{{ $item->id }}/view"
                        class="inline-flex items-center gap-1.5 rounded-lg border border-slate-200 px-3 py-1.5 text-slate-700 transition hover:bg-slate-50">

                            <svg class="h-4 w-4" fill="none" stroke="currentColor"
                                stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                            </svg>

                            View
                        </a>
                        <a href="/items/{{ $item->id }}/edit"
                            class="inline-flex items-center gap-1.5 rounded-lg border border-slate-200 px-3 py-1.5 text-slate-700 transition hover:bg-slate-50">

                                <svg class="h-4 w-4"
                                    fill="none"
                                    stroke="currentColor"
                                    stroke-width="2"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round"
                                        stroke-linejoin="round"
                                        d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/>
                                </svg>
                                Edit
                        </a>
                        <form action="/item/{{ $item->id }}/delete" method="POST"
                            onsubmit="return confirm('Are you sure you want to delete this item?');">

                            @csrf
                            @method('DELETE')

                            <button type="submit"
                                class="inline-flex items-center gap-1.5 rounded-lg border border-red-200 px-3 py-1.5 text-red-600 transition hover:bg-red-50">

                                <svg class="h-4 w-4"
                                    fill="none"
                                    stroke="currentColor"
                                    stroke-width="2"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round"
                                        stroke-linejoin="round"
                                        d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                </svg>

                                Delete
                            </button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    
   {{-- Show pagination only when needed --}}
    @if ($items->hasPages())
        <div class="mt-5 flex flex-col gap-4 rounded-xl border border-slate-200 bg-white px-6 py-4 sm:flex-row sm:items-center sm:justify-between">

            <div class="flex justify-center">
                {{ $items->onEachSide(1)->links() }}
            </div>

        </div>
    @endif
</main>
@endsection