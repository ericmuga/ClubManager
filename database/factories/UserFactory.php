<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    /**
     * The current password being used by the factory.
     */
    protected static ?string $password;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
   public function definition()
    {
        return [
            'name' => $this->faker->name(),
            'email' => $this->faker->unique()->safeEmail(),
            'status' => 'active',
            'user_type' => $this->faker->randomElement(['member','guest']),
            'nationality' => 'Kenyan',
            'gender' => 'M',
            'email_verified_at' => now(),
            'password' => bcrypt('password'), // or use Hash::make('password')
            'classification_id' => null, // or use a random classification id
            'avatar' => $this->faker->imageUrl(),
            'remember_token' => Str::random(10),
            'member_no'=>$this->faker->numberBetween(10000,20000),
            'phone'=>$this->faker->numberBetween(10000,20000)
        ];
    }
    /**
     * Indicate that the model's email address should be unverified.
     */
    public function unverified(): static
    {
        return $this->state(fn (array $attributes) => [
            'email_verified_at' => null,
        ]);
    }
}
