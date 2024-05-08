<?php

namespace Database\Factories;

use App\Models\Quotation;
use Illuminate\Database\Eloquent\Factories\Factory;

class QuotationFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Quotation::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'quotation_date' => $this->faker->dateTimeThisYear(),
            'quotation_no' => $this->faker->unique()->randomNumber(),
            'quotation_status' => $this->faker->randomElement(['pending', 'completed', 'cancelled']),
            'product_id' => function () {
                return \App\Models\Product::factory()->create()->id;
            },
            'quantity' => $this->faker->numberBetween(1, 10),
            'unitcost' => $this->faker->numberBetween(100, 1000),
            'total' => $this->faker->numberBetween(100, 10000),
        ];
    }
}
