<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Item;

class ItemController extends Controller
{
     // Show Item Page
    public function showItemPage(Request $request)
    {
        $search = $request->input('search');

        $items = Item::query()
            ->when($search, function ($query) use ($search) {
                $query->where(function ($query) use ($search) {
                    $query->where('name', 'like', "%{$search}%")
                        ->orWhere('description', 'like', "%{$search}%");
                });
            })
            ->paginate(5)
            ->withQueryString();

        return view(
            'items.indexPage',
            compact('items', 'search')
        );
    }

     // Show Item Create Page
    public function createPage()
    {
        return view('Items.addItem');
    }

    //Save Item
     public function saveItem(Request $request)
    {
         $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0|max:99999999.99',
        ]);
        Item::create($validated);
        return redirect('/item');

    }
    //view Page
    public function ViewPage($id)
    {
        // Find the item and load its related orders.
        // We also load 'user' through the order to show the customer's name.
        $item = Item::with(['orders' => function($query) {
            $query->with('user')->latest();
        }])->findOrFail($id);
        
        return view('Items.view',compact('item'));

    }

    //Edit
    public function edit($id)
    {
        $item= Item::find($id);
        return view('Items.edit',compact('item'));

    }
    //update
    public function update(Request $request,$id){
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0|max:99999999.99',
        ]);
        // dd($validated);
         $item = Item::findOrFail($id);

        $item->Update($validated);
        
        return redirect('/item')->with('success', 'Item updated successfully!');
    }

    //Delete
     public function delete($id){
        // dd($id); dump($student); dd($student->getAttributes());
        $item = Item::findOrFail($id);

         if ($item->orders()->exists()) {
        return back()->with('error', 'This item is used in orders and cannot be deleted.');
        }

        $item->delete();
        return redirect('/item')->with('success', 'Item deleted successfully!');;
    }
}
