<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
{
    public function up(): void
    {
        Schema::disableForeignKeyConstraints(); // Nonaktifkan kunci asing sementara

        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->foreignId('category_id')->constrained('category')->onDelete('cascade');
            $table->string('product_code');
            $table->foreignId('purchase_id')->nullable()->constrained('purchases')->onDelete('cascade'); // Buang default(NULL) dan tetapkan nullable
            $table->foreignId('order_id')->nullable()->constrained('orders')->onDelete('cascade'); // Buang default(NULL) dan tetapkan nullable
            $table->foreignId('unit_id')->nullable()->constrained('units')->onDelete('cascade');
            $table->string('image')->nullable();
            $table->timestamps();
        });

        Schema::enableForeignKeyConstraints(); // Aktifkan kembali kunci asing
    }

    public function down(): void
    {
        Schema::dropIfExists('products');
    }
}
