<?php

use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PurchaseController;

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
    Route::get('home', function () {
        return view('pages.dashboard');
    })->name('home');

    Route::resource('user', UserController::class);
    Route::resource('category', \App\Http\Controllers\CategoryController::class);
    Route::resource('customer', \App\Http\Controllers\CustomerController::class);
    Route::resource('purchase', \App\Http\Controllers\PurchaseController::class);
    Route::get('purchase/accept', 'PurchaseController@accept')->name('purchase.accept');
    Route::get('purchase/cancel', 'PurchaseController@cancel')->name('purchase.cancel');
    Route::get('/purchases/export', [PurchaseController::class, 'exportToExcel'])->name('purchase.export.excel');
    Route::resource('supplier', \App\Http\Controllers\SupplierController::class);
    Route::resource('unit', \App\Http\Controllers\UnitController::class);
    Route::resource('product', \App\Http\Controllers\ProductController::class);
    Route::resource('order', \App\Http\Controllers\OrderController::class);
    Route::resource('quotation', \App\Http\Controllers\QuotationController::class);
});
