<?php

namespace Database\Factories;

use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProductFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Product::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->word,
            'category_id' => function () {
                return \App\Models\Category::factory()->create()->id;
            },
            'product_code' => $this->faker->unique()->isbn10,
            'buying_price' => $this->faker->numberBetween(100, 1000),
            'selling_price' => $this->faker->numberBetween(1000, 5000),
            'stock' => $this->faker->numberBetween(0, 100),
            'unit_id' => function () {
                return \App\Models\Unit::factory()->create()->id;
            },
            'image' => null, // You may adjust this based on your requirements
        ];
    }
}
