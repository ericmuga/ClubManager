<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\Meeting;

class MeetingFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Meeting::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'type' => $this->faker->word(),
            'date' => $this->faker->dateTime(),
            'venue' => $this->faker->word(),
            'topic' => $this->faker->word(),
            'host' => $this->faker->text(),
            'uuid' => $this->faker->uuid(),
            'meeting_no' => $this->faker->randomNumber(),
            'official_start_time' => $this->faker->text(),
            'official_end_time' => $this->faker->text(),
            'detail' => $this->faker->text(),
        ];
    }
}
