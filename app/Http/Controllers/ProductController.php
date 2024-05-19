<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;
use App\Models\Unit;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        Cache::flush();
        $products = Product::with('category', 'unit', 'purchaseDetails')
            ->when($request->input('name'), function ($query, $name) {
                return $query->where('name', 'like', '%' . $name . '%');
            })
            ->orderByDesc('created_at')
            ->paginate(10);

        return view('pages.products.index', compact('products'));
    }

    public function create()
    {
        $categories = Category::all();
        $units = Unit::all();
        return view('pages.products.create', compact('categories', 'units'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|min:3|unique:products',
            'category_id' => 'required|exists:category,id',
            'unit_id' => 'required|exists:units,id',
            'image' => 'required|image|mimes:png,jpg,jpeg|max:2048',
        ]);

        $productCode = '88' . mt_rand(1000000, 9999999);

        $product = new Product();
        $product->name = $request->name;
        $product->category_id = $request->category_id;
        $product->unit_id = $request->unit_id;
        $product->product_code = $productCode;
        $product->image = $request->file('image')->store('public/products');
        $product->save();

        return redirect()->route('product.index')->with('success', 'Product successfully created');
    }

    public function edit($id)
    {
        $product = Product::findOrFail($id);
        $categories = Category::all();
        $units = Unit::all();
        return view('pages.products.edit', compact('product', 'categories', 'units'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|min:3|unique:products,name,' . $id,
            'category_id' => 'required|exists:categories,id',
            'unit_id' => 'required|exists:units,id',
            'image' => 'nullable|image|mimes:png,jpg,jpeg|max:2048',
        ]);

        $product = Product::findOrFail($id);
        $product->name = $request->name;
        $product->category_id = $request->category_id;
        $product->unit_id = $request->unit_id;

        if ($request->hasFile('image')) {
            Storage::delete($product->image);
            $product->image = $request->file('image')->store('public/products');
        }

        $product->save();

        return redirect()->route('product.index')->with('success', 'Product successfully updated');
    }

    public function destroy($id)
    {
        $product = Product::findOrFail($id);
        Storage::delete($product->image);
        $product->delete();
        return redirect()->route('product.index')->with('success', 'Product successfully deleted');
    }
}
