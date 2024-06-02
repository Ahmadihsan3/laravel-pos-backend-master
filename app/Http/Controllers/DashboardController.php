<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Purchase;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        // Get date range from request, default to current month if not provided
        $startDate = $request->input('start_date', date('Y-m-01'));
        $endDate = $request->input('end_date', date('Y-m-t'));

        $products = Product::orderBy('stock', 'desc')->get();
        $totalPurchases = Purchase::count();
        $totalOrders = Order::count();

        // Fetch purchase data for the selected date range
        $purchases = DB::table('purchase_details')
            ->join('products', 'purchase_details.product_id', '=', 'products.id')
            ->select('products.name', DB::raw('SUM(purchase_details.quantity) as total'))
            ->whereBetween('purchase_details.created_at', [$startDate, $endDate])
            ->groupBy('products.name')
            ->orderBy('total', 'desc')
            ->get();

        $orders = DB::table('order_details')
            ->join('products', 'order_details.product_id', '=', 'products.id')
            ->select('products.name', DB::raw('SUM(order_details.quantity) as total'))
            ->whereBetween('order_details.created_at', [$startDate, $endDate])
            ->groupBy('products.name')
            ->orderBy('total', 'desc')
            ->get();

        return view('pages.dashboard', compact('products', 'totalPurchases', 'totalOrders', 'purchases', 'startDate', 'endDate', 'orders'));
    }
}
