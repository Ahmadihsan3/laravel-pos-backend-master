<?php

namespace App\Http\Controllers;

use App\Models\Supplier;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SupplierController extends Controller
{
    public function index(Request $request)
    {
        $suppliers = DB::table('suppliers')
            ->when($request->input('name'), function ($query, $name) {
                return $query->where('name', 'like', '%' . $name . '%');
            })
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        // Periksa apakah ada data yang ditemukan
        if ($suppliers->isEmpty()) {
            return view('pages.suppliers.index')->with('suppliers', $suppliers);
        }

        return view('pages.suppliers.index', compact('suppliers'));
    }


    public function create()
    {
        return view('pages.suppliers.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|min:3|unique:suppliers',
            'email' => 'required|string|email|max:255|unique:suppliers',
            'phone' => 'required|integer',
            'address' => 'required|string',
            'shop_name' => 'required|string',
            'bank_name' => 'required|string',
            'account_header' => 'required|string',
            'account_number' => 'required|integer',
        ]);

        $data = $request->all();
        Supplier::create($data);

        return redirect()->route('supplier.index')->with('success', 'Supplier successfully created');
    }

    public function edit($id)
    {
        $suppliers = \App\Models\Supplier::findOrFail($id);
        return view('pages.suppliers.edit', compact('suppliers'));
    }

    public function update(Request $request, $id)
    {
        $data = $request->all();
        $suppliers = \App\Models\Supplier::findOrFail($id);
        $suppliers->update($data);
        return redirect()->route('supplier.index')->with('success', 'Supplier successfully updated');
    }

    public function destroy($id)
    {
        $suppliers = \App\Models\Supplier::findOrFail($id);
        $suppliers->delete();
        return redirect()->route('supplier.index')->with('success', 'Supplier successfully deleted');
    }
}

