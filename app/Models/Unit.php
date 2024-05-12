<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Unit extends Model
{

    protected $table = 'units';

    use HasFactory;

    protected $fillable = [
        'name',
        'parent_id',
        'quantity',
        'created_at',
        'updated_at',
    ];

    protected $attributes = [
        'parent_id' => null,
        'quantity' => 0,
    ];

    public function parent()
    {
        return $this->belongsTo(Unit::class, 'parent_id');
    }
}
