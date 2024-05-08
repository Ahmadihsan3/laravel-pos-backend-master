<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Category;
use App\Models\Unit;
use App\Models\Order;
use App\Models\Purchase;

class Product extends Model
{

    protected $table = 'products';

    use HasFactory;

    protected $fillable = [
        'name',
        'product_code',
        'category_id',
        'image'
        // Hilangkan 'purchase_id' dari sini, karena Anda ingin membiarkannya kosong saat membuat produk baru
    ];

    protected $guarded = [];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function unit()
    {
        return $this->belongsTo(Unit::class);
    }

    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    public function purchases()
    {
        return $this->hasMany(Purchase::class);
    }

    public function getPricePurchaseAttribute()
    {
        // Mengambil harga dari pembelian terakhir jika ada
        $latestPurchase = $this->purchases()->latest()->first();
        return $latestPurchase ? $latestPurchase->price : null;
    }

    public function getPriceOrdersAttribute()
    {
        // Mengambil harga dari pesanan terakhir jika ada
        $latestOrder = $this->orders()->latest()->first();
        return $latestOrder ? $latestOrder->price : null;
    }

    public function getNameUnitsAttribute()
    {
        // Mengambil nama unit dari pesanan terakhir jika ada
        $latestOrder = $this->orders()->latest()->first();
        return $latestOrder ? $latestOrder->unit->name : null;
    }

    public function getStockAttribute()
    {
        // Mengambil total stok dari semua pesanan
        return $this->orders()->sum('quantity');
    }

    public function getTotalStockAttribute()
    {
        // Mengambil total stok dari semua pesanan dan dikalikan dengan kuantitas unit
        $latestOrder = $this->orders()->latest()->first();
        return $latestOrder ? $latestOrder->quantity * $latestOrder->unit->quantity : null;
    }
}
