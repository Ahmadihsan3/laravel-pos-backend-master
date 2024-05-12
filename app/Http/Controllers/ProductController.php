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
        $products = Product::with('category', 'unit')
            ->when($request->input('name'), function ($query, $name) {
                return $query->where('name', 'like', '%' . $name . '%');
            })
            ->orderByDesc('created_at')
            ->paginate(10);

        return view('pages.products.index', compact('products'));
    }

    public function create()
    {
        $categories = Category::all(); // Memperbaiki nama variabel agar sesuai dengan pemanggilannya di view
        $unit = Unit::all();
        return view('pages.products.create', compact('categories', 'unit')); // Memperbaiki pemanggilan variabel di view
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|min:3|unique:products',
            'category_id' => 'required|exists:category,id', // Memperbaiki pengecekan validasi untuk kategori
            'unit_id' => 'required|exists:units,id',
            'image' => 'required|image|mimes:png,jpg,jpeg|max:2048', // Menambahkan max size untuk gambar (dalam kilobit)
        ]);

        // Assign random product code
        $productCode = '88' . mt_rand(1000000, 9999999);

        $product = new Product();
        $product->name = $request->name;
        $product->category_id = $request->category_id;
        $product->unit_id = $request->unit_id;
        $product->product_code = $productCode;
        $product->image = $request->file('image')->store('public/products');
        $product->save();


        // Tidak perlu lagi mengisi atau memvalidasi unit_id atau purchase_id

        return redirect()->route('product.index')->with('success', 'Product successfully created');
    }

    public function edit($id)
    {
        $product = Product::findOrFail($id);
        $categories = Category::all(); // Memperbaiki nama variabel agar sesuai dengan pemanggilannya di view
        $unit = Unit::all();
        return view('pages.products.edit', compact('product', 'categories', 'unit')); // Memperbaiki pemanggilan variabel di view
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|min:3|unique:products,name,' . $id,
            'category_id' => 'required|exists:categories,id', // Memperbaiki pengecekan validasi untuk kategori
            'unit_id' => 'required|exists:units,id',
            'image' => 'nullable|image|mimes:png,jpg,jpeg|max:2048', // Menambahkan max size untuk gambar (dalam kilobit)
        ]);

        $product = Product::findOrFail($id);
        $product->name = $request->name;
        $product->category_id = $request->category_id;
        $product->unit_id = $request->unit_id;

        if ($request->hasFile('image')) {
            // Hapus gambar lama sebelum menyimpan yang baru
            Storage::delete($product->image);
            $product->image = $request->file('image')->store('public/products');
        }

        $product->save();

        return redirect()->route('product.index')->with('success', 'Product successfully updated');
    }

    public function destroy($id)
    {
        $product = Product::findOrFail($id);
        // Hapus gambar sebelum menghapus produk
        Storage::delete($product->image);
        $product->delete();
        return redirect()->route('product.index')->with('success', 'Product successfully deleted');
    }
}
