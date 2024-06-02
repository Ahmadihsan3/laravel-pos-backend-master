<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {

        \App\Models\User::factory()->create([
            'name' => 'Ahmad Ihsan',
            'email' => 'ihsan@admin.com',
            'password' => Hash::make('12345678'),
            'role' => 'admin',
        ]);

        \App\Models\Unit::create([
            "id" => 1,
            "name" => "PCS",
            "parent_id" => null,
            "quantity" => 1
        ]);

        \App\Models\Category::create([
            "id" => 1,
            "name" => "Sembako"
        ]);

        \App\Models\Supplier::create([
            "name" => "Deny",
            "email" => "deny@demo.com",
            "phone" => "0821412412",
            "shop_name" => "Toko Baterai",
            "bank_name" => "BCA",
            "account_header" => "Deny",
            "account_number" => "12345566",
            "address" => "Bogor"
        ]);

        \App\Models\Customer::create([
            "name" => "Budi",
            "email" => "budi@demo.com",
            "phone" => "08999277428",
            "address" => "Bogor",
            "bank_name" => "BCA",
            "account_header" => "Budi",
            "account_number" => "12345566",
        ]);

        \App\Models\Product::create([
            "name" => "GG FILTER 12",
            "category_id" => 1,
            "product_code" => "888410475",
            "unit_id" => 1,
            "stock" => 0,
            "image" => "public/products/MepKNLRMzLzdK40lAIJwcXXhoEIpUHqfFMe7qq0l.jpg",
        ]);

        \App\Models\Product::create([
            "name" => "SK KRETEK 12",
            "category_id" => 1,
            "product_code" => "886510475",
            "unit_id" => 1,
            "stock" => 0,
            "image" => "public/products/MepKNLRMzLzdK40lAIJwcXXhoEIpUHqfFMe7qq0l.jpg",
        ]);

        \App\Models\Product::create([
            "name" => "JR SUPER 20",
            "category_id" => 1,
            "product_code" => "888443475",
            "unit_id" => 1,
            "stock" => 0,
            "image" => "public/products/MepKNLRMzLzdK40lAIJwcXXhoEIpUHqfFMe7qq0l.jpg",
        ]);

    }
}
