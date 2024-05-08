<?php

namespace Database\Factories;

use App\Models\Order;
use Illuminate\Database\Eloquent\Factories\Factory;

class OrderFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Order::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'customer_id' => function () {
                return \App\Models\Customer::factory()->create()->id;
            },
            'order_date' => $this->faker->dateTimeThisYear(),
            'order_status' => $this->faker->randomElement(['pending', 'completed', 'cancelled']),
            'total_products' => $this->faker->numberBetween(1, 10),
            'sub_total' => $this->faker->numberBetween(100, 1000),
            'var' => $this->faker->numberBetween(1, 10),
            'total' => $this->faker->numberBetween(100, 10000),
            'invoice_no' => $this->faker->unique()->numerify('INV####'),
            'payment_type' => $this->faker->randomElement(['cash', 'card', 'online']),
            'pay' => $this->faker->numberBetween(100, 10000),
            'due' => $this->faker->numberBetween(0, 5000),
        ];
    }
}
