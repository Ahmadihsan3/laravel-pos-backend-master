<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable =
    [
        'id',
        'invoice_no',
        'customer_id',
        'product_id',
        'order_date',
        'quantity',
        'total_products',
        'total',
        'unicost',
        'pay',
        'due',
        'payment_type',
        'order_status',
        'created_at',
        'update_at'
    ];

}
