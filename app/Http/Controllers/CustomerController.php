<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CustomerController extends Controller
{
    public function index(Request $request)
    {
        //get data products
        $customers = DB::table('customers')
            ->when($request->input('name'), function ($query, $name) {
                return $query->where('name', 'like', '%' . $name . '%');
            })
            ->orderBy('created_at', 'desc')
            ->paginate(10);
        //sort by created_at desc

        return view('pages.customers.index', compact('customers'));
    }

    public function create()
    {
        return view('pages.customers.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|min:3|unique:customers',
            'email' => 'required|string|email|max:255|unique:customers',
            'phone' => ['required', 'regex:/^08[0-9]{8,13}$/'], // Validasi regex
            'address' => 'required|string',
            'bank_name' => 'required|string',
            'account_header' => 'required|string',
            'account_number' => 'required|integer',
        ]);

        $data = $request->all();
        Customer::create($data);

        return redirect()->route('customer.index')->with('success', 'Customer successfully created');
    }




    public function edit($id)
    {
        $customers = \App\Models\Customer::findOrFail($id);
        return view('pages.customers.edit', compact('customers'));
    }

    public function update(Request $request, $id)
    {
        $data = $request->all();
        $customers = \App\Models\Customer::findOrFail($id);
        $customers->update($data);
        return redirect()->route('customer.index')->with('success', 'Product successfully updated');
    }

    public function destroy($id)
    {
        $customers = \App\Models\Customer::findOrFail($id);
        $customers->delete();
        return redirect()->route('customer.index')->with('success', 'Product successfully deleted');
    }
}
