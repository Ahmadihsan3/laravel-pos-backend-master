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

        // \App\Models\Product::create([
        //     "name" => "Beras 1KG",
        //     "product_code" => "PRD-1000",
        //     "category_id" => 1,
        //     "image" => ""
        // ]);

    }
}
