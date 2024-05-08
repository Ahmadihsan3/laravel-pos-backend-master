<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Purchase extends Model
{

    protected $table = 'purchases';

    use HasFactory;

    protected $fillable = [
        'id',
        'no_purchase',
        'date_purchase',
        'product_id',
        'quantity',
        'total_quantity',
        'price',
        'payment',
        'supplier_id',
        'unit_id',
        'created_at',
        'updated_at'
    ];

    protected $guarded = [];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function supplier()
    {
        return $this->belongsTo(Supplier::class);
    }

    public function unit()
    {
        return $this->belongsTo(Unit::class);
    }
}
