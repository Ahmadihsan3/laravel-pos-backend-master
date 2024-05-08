<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    //index
    public function index(Request $request)
{
    // Get order data
    $orders = DB::table('orders')
        ->when($request->input('invoice_no'), function ($query, $invoice_no) {
            return $query->where('invoice_no', 'like', '%' . $invoice_no . '%');
        })
        ->orderBy('created_at', 'desc')
        ->paginate(10);

    return view('pages.orders.index', compact('orders'));
}


    public function create()
    {
        return view('pages.orders.create');
    }

    // public function store(Request $request)
    // {
    //     $request->validate([
    //         'name' => 'required|min:3|unique:products',
    //         'price' => 'required|integer',
    //         'stock' => 'required|integer',
    //         'category' => 'required|in:food,drink,snack',
    //         'image' => 'required|image|mimes:png,jpg,jpeg'
    //     ]);

    //     $filename = time() . '.' . $request->image->extension();
    //     $request->image->storeAs('public/products', $filename);
    //     $data = $request->all();

    //     $product = new \App\Models\Product;
    //     $product->name = $request->name;
    //     $product->price = (int) $request->price;
    //     $product->stock = (int) $request->stock;
    //     $product->category = $request->category;
    //     $product->image = $filename;
    //     $product->save();

    //     return redirect()->route('product.index')->with('success', 'Product successfully created');
    // }

    // public function edit($id)
    // {
    //     $product = \App\Models\Product::findOrFail($id);
    //     return view('pages.products.edit', compact('product'));
    // }

    // public function update(Request $request, $id)
    // {
    //     $data = $request->all();
    //     $product = \App\Models\Product::findOrFail($id);
    //     $product->update($data);
    //     return redirect()->route('product.index')->with('success', 'Product successfully updated');
    // }

    // public function destroy($id)
    // {
    //     $product = \App\Models\Product::findOrFail($id);
    //     $product->delete();
    //     return redirect()->route('product.index')->with('success', 'Product successfully deleted');
    // }
}
