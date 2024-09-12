<?php

namespace Database\Factories;
use App\Models\EntryType;
use App\Models\User;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Entry>
 */
class EntryFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'entry_type_id' => EntryType::factory(), // Assuming EntryType has its own factory
            'user_id' => User::factory()->nullable(), // Nullable user
            'description' => $this->faker->sentence(),
            'posting_date' => $this->faker->date(),
            'user_type' => $this->faker->randomElement(['member', 'guest']), // Example user types
            'currency_code' => $this->faker->currencyCode(),
            'amount' => $this->faker->randomFloat(2, 0, 10000), // Random amount with 2 decimals
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
