<?php

namespace App\Http\Controllers;

// use App\Models\Purchase;
use App\Models\Product;
use App\Models\Purchase;
use App\Models\Order;
use App\Models\Quotation;

class DashboardController extends Controller
{
    public function index()
    {
        $products = Product::orderBy('stock', 'desc')->get();
        $totalPurchases = Purchase::count();
        $totalOrders = Order::count();
        $totalQuotations = Quotation::count();

        return view('pages.dashboard', compact('products', 'totalPurchases', 'totalOrders', 'totalQuotations'));
    }
}
