<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Unit;

class UnitController extends Controller
{
    public function index(Request $request)
    {
        // Mengambil data unit beserta relasi 'parent'
        $units = Unit::with('parent')
            ->when($request->input('name'), function ($query, $name) {
                return $query->where('name', 'like', '%' . $name . '%');
            })
            ->orderBy('parent_id', 'asc') // Sort by parent ID
            ->orderBy('created_at', 'asc') // Then, sort by creation time
            ->paginate(5);

        // Mengirimkan data ke tampilan 'unit.index'
        return view('pages.units.index', compact('units'));
    }

    public function store(Request $request)
    {
        // Validasi input dari form
        $request->validate([
            'name' => 'required|min:2|unique:units',
        ]);

        // Buat record baru dengan menentukan hanya 'name'
        $newUnit = Unit::create([
            'name' => $request->name
        ]);

        if ($request->has('parent_id') && $request->has('quantity')) {
            $newUnit->update([
                'parent_id' => $request->parent_id,
                'quantity' => $request->quantity
            ]);
        }

        // Redirect ke halaman index dengan pesan sukses
        return redirect()->route('unit.index')->with('success', 'Unit berhasil dibuat.');
    }



    public function create()
    {
        $units = Unit::all(); // Mendapatkan semua unit untuk opsi parent
        return view('pages.units.create', compact('units'));
    }


    public function edit($id)
    {
        $unit = Unit::findOrFail($id);
        $units = Unit::all(); // Mendapatkan semua unit untuk opsi parent
        return view('pages.units.edit', compact('unit', 'units'));
    }


    public function update(Request $request, $id)
    {
        $data = $request->all();
        $product = \App\Models\Unit::findOrFail($id);
        $product->update($data);
        return redirect()->route('unit.index')->with('success', 'units successfully updated');
    }

    public function destroy($id)
    {
        $product = \App\Models\Unit::findOrFail($id);
        $product->delete();
        return redirect()->route('unit.index')->with('success', 'units successfully deleted');
    }
}
