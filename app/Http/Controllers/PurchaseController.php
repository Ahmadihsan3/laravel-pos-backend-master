<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Purchase;
use App\Models\Product;
use App\Models\Supplier;
use App\Models\Unit;
use Carbon\Carbon;
use App\Exports\PurchasesExport;
use App\Models\PurchaseDetail;
use Exception;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;


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
        $products = json_decode($request->input('products'));

        $total_price = 0;
        foreach ($products as $product) {
            $total_price += $product->total;
        }

        // Generate purchase number
        $lastPurchase = Purchase::latest()->first();
        $date_purchase = Carbon::now()->setTimezone('Asia/Jakarta')->toDateTimeString();
        $lastNumber = $lastPurchase ? (int)substr($lastPurchase->no_purchase, -5) : 0;
        $no_purchase = Carbon::now()->format('dmY') . '-' . str_pad(($lastNumber + 1), 5, '0', STR_PAD_LEFT);

        $purchase = new Purchase();
        $purchase->no_purchase = $no_purchase;
        $purchase->payment = $request->input('payment');
        $purchase->supplier_id = $request->input('supplier_id');
        $purchase->date_purchase = $date_purchase;
        $purchase->total_price = $total_price;
        $purchase->save();

        foreach ($products as $product) {
            PurchaseDetail::create([
                "purchase_id" => $purchase->id,
                "product_id" => $product->product_id,
                "unit_id" => $product->unit_id,
                "quantity" => $product->qty,
                "price" => $product->price,
                "total_price" => $product->total,
            ]);
        }


        return redirect()->route('purchase.index')->with('success', 'Purchase created successfully');
    }

    // Contoh dalam PurchaseController
    public function accept(Request $request, $id)
    {
        $purchase = Purchase::findOrFail($id);
        if (!$purchase->selected_cancel) { // Memastikan pembelian belum dipilih untuk cancel
            $purchase->selected = 1;
            $purchase->save();

            Cache::flush();

            // Redirect ke halaman detail pembelian atau ke halaman lain
            return redirect("/purchase");
        } else {
            // Redirect ke halaman lain atau tampilkan pesan kesalahan
            return redirect("/purchase");
        }
    }

    public function delivery(Request $request, $id)
    {
        $purchase = Purchase::findOrFail($id);
        if (!$purchase->selected_cancel) { // Memastikan pembelian belum dipilih untuk cancel
            $purchase->selected = 3;
            $purchase->save();

            $purchaseDetails = PurchaseDetail::where("purchase_id", $purchase->id)->get(); // Ambil objek Product
            foreach ($purchaseDetails as $detail) {

                $product = Product::find($detail->product_id);
                $product->increment('stock', $detail->quantity); // Menambah stok produk
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

    public function exportToExcel($purchase_id)
    {
        return Excel::download(new PurchasesExport($purchase_id), 'purchases.xlsx');
    }

    public function show($id)
    {
        $purchase = Purchase::findOrFail($id);
        $purchaseDetail = PurchaseDetail::where('purchase_id', $id)->get();

        return view('pages.purchases.show', compact('purchase', 'purchaseDetail'));
    }

    public function edit($id)
    {
        $purchase = Purchase::findOrFail($id);
        $purchaseDetails = $purchase->purchaseDetails; // Use the relationship to get the details
        $products = Product::all();
        $units = Unit::all();
        $suppliers = Supplier::all();

        return view('pages.purchases.edit', compact('purchase', 'purchaseDetails', 'products', 'units', 'suppliers'));
    }

    public function update(Request $request, $id)
    {
        try {
            DB::beginTransaction();
            // Validate the incoming request data
            $request->validate([
                // 'payment' => 'required|in:Cash,Transfer',
                // 'supplier_id' => 'required|exists:suppliers,id',
                // 'products' => 'required|array', // Ubah validasi untuk produk menjadi array
                // 'products.*.product_id' => 'required|exists:products,id', // Validasi product_id untuk setiap item
                // 'products.*.unit_id' => 'required|exists:units,id', // Validasi unit_id untuk setiap item
                // 'products.*.qty' => 'required|integer|min:1', // Validasi qty untuk setiap item
                // 'products.*.price' => 'required|numeric|min:0', // Validasi price untuk setiap item
                // 'products.*.total' => 'required|numeric|min:0', // Validasi total untuk setiap item
            ]);

            // // Find the purchase record
            // $purchase = Purchase::findOrFail($id);
            // // Update the purchase record
            // $purchase->payment = $request->input('payment');
            // $purchase->supplier_id = $request->input('supplier_id');
            // $purchase->save();
            // Decode the products JSON string
            $products = json_decode($request->input('products'));

            // Clear existing purchase details
            $data = Purchase::where('id', $id)->first();
            $purchase_id = $data->purchase_id;
            $total_price = 0;


            // // Loop through each product and create new purchase detail records
            foreach ($products as $product) {
                $total_price += $product->total;

                $purchaseProduct = PurchaseDetail::where("purchase_id", $id)
                    ->where("product_id", $product->product_id)
                    ->first();

                $purchaseProduct->quantity = $product->qty;
                $purchaseProduct->price = $product->price;
                $purchaseProduct->total_price = $product->total;
                $purchaseProduct->save();

            }

            // // Update the total price of the purchase
            $purchase = Purchase::find($id);
            $purchase->total_price = $total_price;
            $purchase->save();

            DB::commit();
            // // Redirect back to purchase index with success message
            return redirect()->route('purchase.index')->with('success', 'Purchase updated successfully');
        } catch (Exception $exception) {
            // Log the exception
            dd($exception->getMessage());
        }
    }
}
