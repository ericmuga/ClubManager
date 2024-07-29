<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\ClubSetting;

class ClubSettingFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = ClubSetting::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'club_name' => $this->faker->regexify('[A-Za-z0-9]{50}'),
            'change_log_active' => $this->faker->boolean(),
            'default_currency' => $this->faker->regexify('[A-Za-z0-9]{5}'),
            'logo' => $this->faker->regexify('[A-Za-z0-9]{100}'),
            'dispatch_emails' => $this->faker->boolean(),
            'active' => $this->faker->boolean(),
            'address' => $this->faker->regexify('[A-Za-z0-9]{100}'),
            'telephone' => $this->faker->regexify('[A-Za-z0-9]{100}'),
            'email' => $this->faker->safeEmail(),
            'slogan' => $this->faker->regexify('[A-Za-z0-9]{100}'),
            'pin' => $this->faker->regexify('[A-Za-z0-9]{100}'),
        ];
    }
}
