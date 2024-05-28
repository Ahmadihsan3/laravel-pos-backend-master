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

    protected $fillable = [];

    protected $guarded = ["id"];

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

    public function purchaseDetails()
    {
        return $this->hasMany(PurchaseDetail::class);
    }

    public function purchases()
    {
        return $this->hasMany(Purchase::class);
    }

}
