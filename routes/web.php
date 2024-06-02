<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('pages.auth.login');
});

Route::middleware(['auth'])->group(function () {
    Route::get('dashboard', function () {
        return view('pages.dashboard');
    })->name('dashboard');

    Route::resource('user', \App\Http\Controllers\UserController::class);
    Route::resource('category', \App\Http\Controllers\CategoryController::class);
    Route::resource('purchase', \App\Http\Controllers\PurchaseController::class);
    Route::get('purchase/action/accept/{id}', [\App\Http\Controllers\PurchaseController::class, 'accept'])->name('purchase.accept');
    Route::get('purchase/action/cancel/{id}', [\App\Http\Controllers\PurchaseController::class, 'cancel'])->name('purchase.cancel');
    Route::get('purchase/action/delivery/{id}', [\App\Http\Controllers\PurchaseController::class, 'delivery'])->name('purchase.delivery');
    Route::get('/purchase/action/edit/{id}', [\App\Http\Controllers\PurchaseController::class, 'edit'])->name('purchase.edit');
    Route::put('purchase/action/update/{id}', [\App\Http\Controllers\PurchaseController::class, 'update'])->name('purchase.update');
    Route::get('purchase/export/{purchase_id}', [\App\Http\Controllers\PurchaseController::class, 'exportToExcel'])->name('purchase.export.excel');
    Route::resource('order', \App\Http\Controllers\OrderController::class);
    Route::get('order/action/accept/{id}', [\App\Http\Controllers\OrderController::class, 'accept'])->name('order.accept');
    Route::get('order/action/cancel/{id}', [\App\Http\Controllers\OrderController::class, 'cancel'])->name('order.cancel');
    Route::get('order/action/delivery/{id}', [\App\Http\Controllers\OrderController::class, 'delivery'])->name('order.delivery');
    Route::get('/order/action/edit/{id}', [\App\Http\Controllers\OrderController::class, 'edit'])->name('order.edit');
    Route::put('order/action/update/{id}', [\App\Http\Controllers\OrderController::class, 'update'])->name('order.update');
    Route::get('order/export/{order_id}', [\App\Http\Controllers\OrderController::class, 'exportToExcel'])->name('order.export.excel');
    Route::resource('customer', \App\Http\Controllers\CustomerController::class);
    Route::resource('supplier', \App\Http\Controllers\SupplierController::class);
    Route::resource('unit', \App\Http\Controllers\UnitController::class);
    Route::resource('product', \App\Http\Controllers\ProductController::class);
    Route::resource('dashboard', \App\Http\Controllers\DashboardController::class);
});
