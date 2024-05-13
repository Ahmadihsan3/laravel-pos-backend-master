<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Purchase;
use App\Models\Product;
use App\Models\Supplier;
use App\Models\Unit;
use Carbon\Carbon;
use App\Exports\PurchasesExport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Cache;

class PurchaseController extends Controller
{
    public function index()
    {
        $selected = request()->query("selected");
        if ($selected !== null) {
            $purchases = Purchase::where("selected", $selected)->paginate(10);
        } else {
            $purchases = Purchase::paginate(10);
        }
        return view('pages.purchases.index', compact('purchases'));
    }

    public function create()
    {
        $products = Product::all();
        $suppliers = Supplier::all();
        $units = Unit::all();
        $purchases = Purchase::all();

        return view('pages.purchases.create', compact('products', 'suppliers', 'units', 'purchases'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
            'price' => 'required|integer|min:0',
            'payment' => 'required|in:cash,transfer',
            'supplier_id' => 'required|exists:suppliers,id',
            'unit_id' => 'required|exists:units,id',
        ]);

        // Generate purchase number
        $lastPurchase = Purchase::latest()->first();
        $date_purchase = Carbon::now()->setTimezone('Asia/Jakarta')->toDateTimeString();
        $lastNumber = $lastPurchase ? (int)substr($lastPurchase->no_purchase, -5) : 0;
        $no_purchase = Carbon::now()->format('dmY') . '-' . str_pad(($lastNumber + 1), 5, '0', STR_PAD_LEFT);

        // Calculate total quantity
        $total_quantity = $request->quantity * Unit::find($request->unit_id)->quantity;

        // Calculate total price
        $total_price = $request->quantity * $request->price;

        $purchase = new Purchase();
        $purchase->fill($request->all());
        $purchase->no_purchase = $no_purchase;
        $purchase->date_purchase = $date_purchase;
        $purchase->total_quantity = $total_quantity;
        $purchase->total_price = $total_price; // Assign total_price
        $purchase->save();

        return redirect()->route('purchase.index')->with('success', 'Purchase created successfully');
    }

    // Contoh dalam PurchaseController
    public function accept(Request $request, $id)
    {
        $purchase = Purchase::findOrFail($id);
        if (!$purchase->selected_cancel) { // Memastikan pembelian belum dipilih untuk cancel
            $purchase->selected = 1;
            $purchase->save();

            $products = Product::where("id", $purchase->product_id)->get(); // Ambil objek Product
            foreach ($products as $product) {
                $product->increment('stock', $purchase->quantity); // Menambah stok produk
                $product->save();
            }

            Cache::flush();

            // Redirect ke halaman detail pembelian atau ke halaman lain
            return redirect("/purchase");
        } else {
            // Redirect ke halaman lain atau tampilkan pesan kesalahan
            return redirect("/purchase");
        }
    }


    public function cancel(Request $request, $id)
    {
        $purchase = Purchase::findOrFail($id);
        if (!$purchase->selected) { // Memastikan pembelian belum dipilih untuk accept
            $purchase->selected = 2;
            $purchase->save();
            // Redirect ke halaman detail pembelian atau ke halaman lain
            return redirect("/purchase");
        } else {
            // Redirect ke halaman lain atau tampilkan pesan kesalahan
            return redirect("/purchase");
        }
    }

    public function exportToExcel()
    {
        return Excel::download(new PurchasesExport, 'purchases.xlsx');
    }

    public function show(Request $request, $id)
    {
        return "OKS";
    }
}
