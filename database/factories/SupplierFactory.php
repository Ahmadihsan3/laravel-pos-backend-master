<?php

namespace Database\Factories;

use App\Models\Supplier;
use Illuminate\Database\Eloquent\Factories\Factory;

class SupplierFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Supplier::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->name,
            'email' => $this->faker->unique()->safeEmail,
            'phone' => $this->faker->phoneNumber,
            'address' => $this->faker->address,
            'shop_name' => $this->faker->company,
            'type' => $this->faker->randomElement(['Retail', 'Wholesale']),
            'bank_name' => $this->faker->randomElement(['Bank A', 'Bank B', 'Bank C']),
            'account_header' => $this->faker->name,
            'account_number' => $this->faker->randomNumber(9),
        ];
    }
}
