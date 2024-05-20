<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Product;
use App\Models\Supplier;
use App\Models\Unit;
use Carbon\Carbon;
use App\Exports\ordersExport;
use App\Models\OrderDetail;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Cache;

class OrderController extends Controller
{
    //index
    public function index()
    {
        $selected = request()->query("selected");
        if ($selected !== null) {
            $orders = Order::where("selected", $selected)->paginate(10);
        } else {
            $orders = Order::paginate(10);
        }
        return view('pages.orders.index', compact('orders'));
    }

    public function create()
    {
        $products = Product::all();
        $suppliers = Supplier::all();
        $units = Unit::all();
        $orders = Order::all();

        return view('pages.orders.create', compact('products', 'suppliers', 'units', 'orders'));
    }

    public function store(Request $request)
    {
        $products = json_decode($request->input('products'));

        $total_price = 0;
        foreach($products as $product ) {
            $total_price += $product->total;
        }
        // $request->validate([
        //     'product_id' => 'required|exists:products,id',
        //     'quantity' => 'required|integer|min:1',
        //     'price' => 'required|integer|min:0',
        //     'payment' => 'required|in:cash,transfer',
        //     'supplier_id' => 'required|exists:suppliers,id',
        //     'unit_id' => 'required|exists:units,id',
        // ]);

        // Generate Order number
        $lastOrder = Order::latest()->first();
        $date_Order = Carbon::now()->setTimezone('Asia/Jakarta')->toDateTimeString();
        $lastNumber = $lastOrder ? (int)substr($lastOrder->no_Order, -5) : 0;
        $no_Order = Carbon::now()->format('dmY') . '-' . str_pad(($lastNumber + 1), 5, '0', STR_PAD_LEFT);

        $Order = new Order();
        $Order->no_Order = $no_Order;
        $Order->payment = $request->input('payment');
        $Order->supplier_id = $request->input('supplier_id');
        $Order->date_Order = $date_Order;
        $Order->total_price = $total_price;
        $Order->save();

        foreach($products as $product ) {
            OrderDetail::create([
                "Order_id" => $Order->id,
                "product_id" => $product->product_id,
                "unit_id" => $product->unit_id,
                "quantity" => $product->qty,
                "price" => $product->price,
                "total_price" => $product->total,
            ]);
        }


        return redirect()->route('Order.index')->with('success', 'Order created successfully');
    }

    // Contoh dalam OrderController
    public function accept(Request $request, $id)
    {
        $Order = Order::findOrFail($id);
        if (!$Order->selected_cancel) { // Memastikan pembelian belum dipilih untuk cancel
            $Order->selected = 1;
            $Order->save();

            Cache::flush();

            // Redirect ke halaman detail pembelian atau ke halaman lain
            return redirect("/Order");
        } else {
            // Redirect ke halaman lain atau tampilkan pesan kesalahan
            return redirect("/Order");
        }
    }

    public function delivery(Request $request, $id)
    {
        $Order = Order::findOrFail($id);
        if (!$Order->selected_cancel) { // Memastikan pembelian belum dipilih untuk cancel
            $Order->selected = 3;
            $Order->save();

            $OrderDetails = OrderDetail::where("Order_id", $Order->id)->get(); // Ambil objek Product
            foreach ($OrderDetails as $detail) {

                $product = Product::find($detail->product_id);
                $product->increment('stock', $detail->quantity); // Menambah stok produk
                $product->save();
            }

            Cache::flush();

            // Redirect ke halaman detail pembelian atau ke halaman lain
            return redirect("/Order");
        } else {
            // Redirect ke halaman lain atau tampilkan pesan kesalahan
            return redirect("/Order");
        }
    }



    public function cancel(Request $request, $id)
    {
        $Order = Order::findOrFail($id);
        if (!$Order->selected) { // Memastikan pembelian belum dipilih untuk accept
            $Order->selected = 2;
            $Order->save();
            // Redirect ke halaman detail pembelian atau ke halaman lain
            return redirect("/Order");
        } else {
            // Redirect ke halaman lain atau tampilkan pesan kesalahan
            return redirect("/Order");
        }
    }

    public function exportToExcel()
    {
        return Excel::download(new ordersExport, 'orders.xlsx');
    }

    public function show($id)
    {
        $Order = Order::findOrFail($id);
        $OrderDetail = OrderDetail::where('Order_id', $id)->get();

        return view('pages.orders.show', compact('Order', 'OrderDetail'));
    }

    public function edit($id)
    {
        $OrderDetail = OrderDetail::findOrFail($id);
        $products = Product::all();
        $units = Unit::all();
        return view('pages.orders.edit', compact('OrderDetail', 'products', 'units'));
    }


    public function update(Request $request, $id)
    {
        $OrderDetail = OrderDetail::findOrFail($id);
        $data = $request->all();
        $OrderDetail->update($data);
        return redirect()->route('/Order')->with('success', 'Order detail updated successfully');
    }
}
