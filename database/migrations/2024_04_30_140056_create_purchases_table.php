<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class CreatePurchasesTable extends Migration
{
    public function up(): void
    {
        Schema::create('purchases', function (Blueprint $table) {
            $table->id();
            $table->string('no_purchase');
            $table->timestamp('date_purchase')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->foreignId('product_id')->constrained('products')->onDelete('cascade');
            $table->unsignedInteger('quantity');
            $table->unsignedInteger('total_quantity');
            $table->unsignedInteger('total_price');
            $table->decimal('price', 10);
            $table->enum('payment', ['cash', 'transfer']);
            $table->foreignId('supplier_id')->constrained('suppliers')->onDelete('cascade');
            $table->foreignId('unit_id')->constrained('units')->onDelete('cascade');
            $table->timestamps();
        });

        Schema::table('purchases', function (Blueprint $table) {
            $table->boolean('selected')->default(false);
        });

    }

    public function down(): void
    {
        Schema::dropIfExists('purchases');
    }
}


