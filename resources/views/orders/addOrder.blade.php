@extends('layouts.app')

@section('content')
<main class="flex-1 overflow-y-auto p-8 text-slate-800">
    
    <!-- 1. Breadcrumbs -->
    <nav class="flex text-sm text-slate-500 mb-4">
        <a href="#" class="hover:text-slate-800 transition">Dashboard</a>
        <span class="mx-2">/</span>
        <a href="#" class="hover:text-slate-800 transition">Orders</a>
        <span class="mx-2">/</span>
        <span class="text-slate-800 font-medium">Create</span>
    </nav>

    <!-- 2. Header -->
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-slate-900">New order</h1>
        <p class="text-slate-500 mt-2">Add items and quantities for this order.</p>
    </div>

    <!-- 3. Main Form Area -->
    <form action="{{ url('/orders/store') }}" method="POST" class="max-w-3xl">
        @csrf
        
        <!-- Status Field -->
        <div class="mb-6">
            <label class="block text-sm font-medium text-slate-900 mb-2">Status</label>
            <select name="status" class="w-full rounded-md border border-slate-300 bg-white px-3 py-2.5 text-sm outline-none focus:border-slate-500 focus:ring-1 focus:ring-slate-500">
                <@foreach($statuses as $key => $value)
                <option value="{{ $key }}">
                    {{ $value }}
                </option>
                @endforeach
            </select>
        </div>

       <!-- Items Section -->
        <div class="mb-8">
            <div class="flex items-center justify-between mb-3">
                <label class="block text-sm font-medium text-slate-900">Items</label>
                <button type="button" id="add-item-btn" class="rounded-md border border-slate-300 bg-white px-4 py-1.5 text-sm font-medium text-slate-700 shadow-sm hover:bg-slate-50 transition">
                    Add Item
                </button>
            </div>

     
            <div id="items-container" class="space-y-3">
                
     
                <div class="item-wrapper">
                    <div class="item-row flex gap-4 items-center bg-slate-50 p-3 rounded-lg border border-slate-200">
                        <div class="flex-1">
                            <select name="items[0][id]" class="item-select w-full rounded-md border border-slate-300 bg-white px-3 py-2.5 text-sm outline-none focus:border-slate-500">
                                <option value="">Select item</option>
                                @foreach($items as $item)
                                    <option value="{{ $item->id }}">{{ $item->name }} (${{ number_format($item->price, 2) }})</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="w-24">
                            <input type="number" name="items[0][quantity]" value="1" min="1" class="w-full rounded-md border border-slate-300 bg-white px-3 py-2.5 text-sm outline-none focus:border-slate-500 text-center">
                        </div>
                        <div>
                            <button type="button" class="remove-btn rounded-md border border-slate-300 bg-white px-4 py-2.5 text-sm font-medium text-slate-400 cursor-not-allowed opacity-50" disabled>
                                Remove
                            </button>
                        </div>
                    </div>
                    

                    @error('items.0.id')
                        <div class="text-red-600 text-sm mt-1 ml-1">{{ $message }}</div>
                    @enderror
                </div>

            </div>
        </div>

       
        <template id="item-row-template">
            <div class="item-wrapper mt-3">
                <div class="item-row flex gap-4 items-center bg-slate-50 p-3 rounded-lg border border-slate-200">
                    <div class="flex-1">
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
            </div>
        </template>

        <!-- Form Actions -->
        <div class="flex items-center gap-4 mt-8">
            <button type="submit" class="bg-slate-900 hover:bg-slate-800 text-white px-5 py-2.5 rounded-md text-sm font-medium transition shadow-sm">
                Create order
            </button>
            <a href="/order" class="text-sm font-medium text-slate-500 hover:text-slate-800 transition">Cancel</a>
        </div>
    </form>
</main>

<!-- JavaScript for Add/Remove logic -->
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const container = document.getElementById('items-container');
        const addBtn = document.getElementById('add-item-btn');
        const template = document.getElementById('item-row-template');
        
        let itemIndex = 1; 

        // Add Item နှိပ်တဲ့အခါ
        addBtn.addEventListener('click', function() {
            // Template ထဲက HTML ကို ယူမယ်
            const newRowHtml = template.innerHTML;
            
            // __INDEX__ နေရာမှာ နံပါတ်အစစ် ထည့်မယ် (ဥပမာ - 1, 2, 3)
            const finalHtml = newRowHtml.replace(/__INDEX__/g, itemIndex);

            // ဖန်တီးထားတဲ့ Row ကို Container ထဲ ထည့်မယ်
            container.insertAdjacentHTML('beforeend', finalHtml);
            
            itemIndex++;
            updateDropdowns(); // ရွေးပြီးသား Item တွေကို ဖျောက်ဖို့ စစ်မယ်
        });

        // Row တစ်ခုကို ဖျက်တဲ့အခါ
        container.addEventListener('click', function(e) {
            if (e.target.classList.contains('remove-btn')) {
                e.target.closest('.item-row').remove();
                updateDropdowns(); // ဖျက်ပြီးတာနဲ့ ပြန်စစ်မယ်
            }
        });

        // Dropdown တစ်ခုခုကို ရွေးတဲ့အခါ
        container.addEventListener('change', function(e) {
            if (e.target.classList.contains('item-select')) {
                updateDropdowns();
            }
        });

        // ★ ရွေးပြီးသား Item တွေကို တခြား Dropdown တွေမှာ ဖျောက်တဲ့ Function ★
        function updateDropdowns() {
            const selects = document.querySelectorAll('.item-select');
            
            // ရွေးထားတဲ့ တန်ဖိုး (ID) တွေကို စုမယ်
            const selectedValues = Array.from(selects)
                                        .map(select => select.value)
                                        .filter(value => value !== "");

            selects.forEach(select => {
                const currentValue = select.value;
                
                // အဲဒီ Dropdown ထဲက Option တွေကို တစ်ခုချင်း စစ်မယ်
                Array.from(select.options).forEach(option => {
                    if (option.value === "") return; // "Select item" ကို ကျော်

                    // အကယ်၍ ဒီ Option က တခြား Dropdown မှာ ရွေးပြီးသားဖြစ်နေရင်
                    if (selectedValues.includes(option.value) && option.value !== currentValue) {
                        option.hidden = true; // ဖျောက်မယ်
                        option.disabled = true; // ရွေးလို့မရအောင် ပိတ်မယ်
                    } else {
                        option.hidden = false; // ပြန်ပြမယ်
                        option.disabled = false;
                    }
                });
            });
        }
    });
</script>
@endsection