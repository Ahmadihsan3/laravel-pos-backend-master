<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Category;

class CategoryController extends Controller
{
    public function index(Request $request)
    {
        $categories = DB::table('category')
            ->when($request->input('name'), function ($query, $name) {
                return $query->where('name', 'like', '%' . $name . '%');
            })
            ->orderBy('id', 'asc') // Assuming you want to order by ID
            ->paginate(5); // Pagination with 5 items per page

        return view('pages.category.index', compact('categories'));
    }



    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|min:2|unique:category',
        ]);

        $category = new \App\Models\Category;
        $category->name = $request->name;
        $category->save(); // Simpan kategori ke database
        return redirect()->route('category.index')->with('success', 'Category successfully created');
    }


    public function create()
    {
        return view('pages.category.create');
    }

    public function edit($id)
    {
        $category = \App\Models\Category::findOrFail($id);
        return view('pages.category.edit', compact('category'));
    }

    public function update(Request $request, $id)
    {
        $data = $request->all();
        $product = \App\Models\Category::findOrFail($id);
        $product->update($data);
        return redirect()->route('category.index')->with('success', 'category successfully updated');
    }

    public function destroy($id)
    {
        $product = \App\Models\Category::findOrFail($id);
        $product->delete();
        return redirect()->route('category.index')->with('success', 'category successfully deleted');
    }
}
