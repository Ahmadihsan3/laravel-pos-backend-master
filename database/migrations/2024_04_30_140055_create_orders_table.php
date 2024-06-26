<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class CreateOrdersTable extends Migration
{
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string('no_order');
            $table->foreignId('customer_id')->constrained('customers')->onDelete('cascade');
            $table->timestamp('date_order')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->unsignedInteger('total_price');
            $table->enum('payment', ['Cash', 'Transfer']);
            $table->boolean('selected')->default(false);
            $table->timestamps();
        });

        Schema::create('order_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')->constrained('orders')->onDelete('cascade');
            $table->foreignId('unit_id')->constrained('units')->onDelete('cascade');
            $table->foreignId('product_id')->constrained('products')->onDelete('cascade');
            $table->unsignedInteger('quantity');
            $table->double('price');
            $table->unsignedInteger('total_price');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
}

