<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Quotation extends Model
{
    use HasFactory;

    protected $fillable = [
        'quotation_date',
        'quotation_no',
        'quotation_status',
        'product_id',
        'quantity',
        'unitcost',
        'total',
    ];

    protected $casts = [
        'quotation_date' => 'datetime',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
