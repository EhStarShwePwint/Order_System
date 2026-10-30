<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB; 

use App\Models\Order;
use App\Models\Item;
use App\Models\OrderItem;

class OrderController extends Controller
{
    // Show Order Page   
    public function showOrderPage(Request $request)
    {
        $search = $request->input('search');

        $query = Order::with('items')->where('user_id', auth()->id());

        if ($search) {
            $query->where(function($q) use ($search) {
                $q->where('id', 'LIKE', "%{$search}%")
                ->orWhere('status', 'LIKE', "%{$search}%")
                ->orWhereHas('items', function($itemQuery) use ($search) {
                    $itemQuery->where('name', 'LIKE', "%{$search}%");
                });
            });
        }
        $orders = $query->latest()->paginate(10)->appends(['search' => $search]);
        
        return view('orders.indexPage', compact('orders', 'search'));

    }

    // Show Order Create Page
    public function createPage()
    {
        $items = \App\Models\Item::all();
    
        // Define status in array
        $statuses = [
            'pending' => 'Pending',
            'processing' => 'Processing',
            'completed' => 'Completed',
            'cancelled' => 'Cancelled',
        ];

    return view('orders.addOrder', compact('items', 'statuses'));
    }

    public function store(Request $request){
        $request->validate([
            'status' => 'required|string|in:pending,processing,completed,cancelled',
            'items' => 'required|array|min:1',
            'items.*.id' => 'required|exists:items,id',
            'items.*.quantity' => 'required|integer|min:1',
        ]);

        try {
            DB::beginTransaction();

            $order = Order::create([
                'user_id' => auth()->id(),
                'status' => $request->status,
                'total' => 0, 
            ]);

            $totalPrice = 0;
            $orderItemsData = [];

            foreach ($request->items as $itemData) {
                $item = Item::findOrFail($itemData['id']);
                
                $subtotal = $item->price * $itemData['quantity'];
                $totalPrice += $subtotal;

                $orderItemsData[$item->id] = [
                    'quantity' => $itemData['quantity'],
                    'unit_price' => $item->price,
                ];
            }

            $order->items()->attach($orderItemsData);

            $order->update(['total' => $totalPrice]);

            DB::commit(); 
    
           return redirect('/order')->with('success', 'Order created successfully!');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Something went wrong: ' . $e->getMessage())->withInput();
        }
    
    }

    public function show($id)
    {
        $order = Order::with('items')->findOrFail($id);
        
        return view('orders.show', compact('order'));
    }

    // 1. Show the Edit Page
    public function edit($id)
    {
        // Find the order by ID along with its related items. Throw a 404 error if not found.
        $order = Order::with('items')->findOrFail($id);
        
        // Get all items from the database to populate the dropdown menu
        $items = Item::all(); 
        
        // Define the available statuses for the dropdown
        $statuses = [
            'pending' => 'Pending',
            'processing' => 'Processing',
            'completed' => 'Completed',
            'cancelled' => 'Cancelled',
        ];

        // Return the 'orders.edit' view and pass the variables to it
        return view('orders.edit', compact('order', 'items', 'statuses'));
    }

    // 2. Update the Order and Save Data
    public function update(Request $request, $id)
    {
        // Validate the incoming request data
        $request->validate([
            'status' => 'required|string|in:pending,processing,completed,cancelled',
            'items' => 'required|array|min:1', // Must have at least one item
            'items.*.id' => 'required|exists:items,id', // The item ID must exist in the database
            'items.*.quantity' => 'required|integer|min:1', // Quantity must be at least 1
        ]);

        try {
            // Start a database transaction to ensure data integrity
            DB::beginTransaction();
            
            // Find the specific order to update
            $order = Order::findOrFail($id);
            
            // Update the order status
            $order->update(['status' => $request->status]);

            $totalPrice = 0;
            $orderItemsData = [];

            // Loop through the submitted items to calculate the new total price
            foreach ($request->items as $itemData) {
                $item = Item::findOrFail($itemData['id']);
                $subtotal = $item->price * $itemData['quantity'];
                $totalPrice += $subtotal;

                // Prepare the data array for the pivot table (order_items)
                $orderItemsData[$item->id] = [
                    'quantity' => $itemData['quantity'],
                    'unit_price' => $item->price,
                ];
            }

            // Use sync() to replace old items with new ones. 
            // It automatically handles removing items that were deleted and adding new ones.
            $order->items()->sync($orderItemsData);
            
            // Update the total price of the order
            $order->update(['total' => $totalPrice]);

            // Commit the transaction (save changes permanently to the database)
            DB::commit(); 

            // Redirect back to the order's show page with a success message
            return redirect()->route('orders.show', $order->id)->with('success', 'Order updated successfully!');
            
        } catch (\Exception $e) {
            // If an error occurs, rollback (undo) all changes made during this transaction
            DB::rollBack();
            
            // Redirect back with an error message and keep the submitted form data
            return back()->with('error', 'Something went wrong: ' . $e->getMessage())->withInput();
        }
    }

    public function destroy($id)
    {
        try {
            DB::beginTransaction();

            $order = Order::findOrFail($id);
            
            $order->items()->detach(); 
            
            $order->delete();

            DB::commit();

            return redirect()->route('orders.index')->with('success', 'Order deleted successfully!');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Something went wrong: ' . $e->getMessage());
        }
    }
}
