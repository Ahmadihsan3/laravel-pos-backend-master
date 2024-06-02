<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Product;
use App\Models\Customer;
use App\Models\Unit;
use Carbon\Carbon;
use App\Exports\OrdersExport;
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
        $customers = Customer::all();
        $units = Unit::all();
        $orders = Order::all();

        return view('pages.orders.create', compact('products', 'customers', 'units', 'orders'));
    }

    public function store(Request $request)
    {
        $products = json_decode($request->input('products'));

        $total_price = 0;
        foreach($products as $product ) {
            $total_price += $product->total;
        }

        // Generate Order number
        $lastOrder = Order::latest()->first();
        $date_order = Carbon::now()->setTimezone('Asia/Jakarta')->toDateTimeString();
        $lastNumber = $lastOrder ? (int)substr($lastOrder->no_order, -5) : 0;
        $no_order = Carbon::now()->format('dmY') . '-' . str_pad(($lastNumber + 1), 5, '0', STR_PAD_LEFT);

        $order = new Order();
        $order->no_order = $no_order;
        $order->payment = $request->input('payment');
        $order->customer_id = $request->input('customer_id');
        $order->date_order = $date_order;
        $order->total_price = $total_price;
        $order->save();

        foreach($products as $product ) {
            OrderDetail::create([
                "order_id" => $order->id,
                "product_id" => $product->product_id,
                "unit_id" => $product->unit_id,
                "quantity" => $product->qty,
                "price" => $product->price,
                "total_price" => $product->total,
            ]);
        }

        return redirect()->route('order.index')->with('success', 'Order created successfully');
    }

    // Contoh dalam OrderController
    public function accept(Request $request, $id)
    {
        $order = Order::findOrFail($id);
        if (!$order->selected_cancel) { // Memastikan pembelian belum dipilih untuk cancel
            $order->selected = 1;
            $order->save();

            Cache::flush();

            // Redirect ke halaman detail pembelian atau ke halaman lain
            return redirect("/order");
        } else {
            // Redirect ke halaman lain atau tampilkan pesan kesalahan
            return redirect("/order");
        }
    }

    public function delivery(Request $request, $id)
    {
        $order = Order::findOrFail($id);
        if (!$order->selected_cancel) { // Memastikan pembelian belum dipilih untuk cancel
            $order->selected = 3;
            $order->save();

            $orderDetails = OrderDetail::where("order_id", $order->id)->get(); // Ambil objek Product
            foreach ($orderDetails as $detail) {

                $product = Product::find($detail->product_id);
                $product->decrement('stock', $detail->quantity); // Menambah stok produk
                $product->save();
            }

            Cache::flush();

            // Redirect ke halaman detail pembelian atau ke halaman lain
            return redirect("/order");
        } else {
            // Redirect ke halaman lain atau tampilkan pesan kesalahan
            return redirect("/order");
        }
    }



    public function cancel(Request $request, $id)
    {
        $order = Order::findOrFail($id);
        if (!$order->selected) { // Memastikan pembelian belum dipilih untuk accept
            $order->selected = 2;
            $order->save();
            // Redirect ke halaman detail pembelian atau ke halaman lain
            return redirect("/order");
        } else {
            // Redirect ke halaman lain atau tampilkan pesan kesalahan
            return redirect("/order");
        }
    }

    public function exportToExcel($order_id)
    {
        return Excel::download(new OrdersExport($order_id), 'orders.xlsx');
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
