<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\EntryType>
 */
class EntryTypeFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
                'code' => strtoupper($this->faker->unique()->lexify('ET???')), // Example code format like 'ET123'
                'description' => $this->faker->sentence(),
                'created_at' => now(),
                'updated_at' => now(),
        ];
    }
}
