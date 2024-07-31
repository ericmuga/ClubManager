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
        $lastMeeting = \App\Models\Meeting::latest('created_at')->first();
        $lastNumber = $lastMeeting ? (int) substr($lastMeeting->meeting_no, 1) : 0;
        $nextNumber = $lastNumber + 1;

        // Format the number with leading zeros and prefix
        $meetingNo = 'M' . str_pad($nextNumber, 6, '0', STR_PAD_LEFT);

        return [
            'type' => $this->faker->randomElement(['Physical','GoogleMeet','Zoom']),
            'date' => $this->faker->dateTime(),
            'venue' => $this->faker->word(),
            'topic' => $this->faker->word(),
            'host' => $this->faker->name(),
            'uuid' => $this->faker->uuid(),
            'meeting_no' => $meetingNo,
            'official_start_time' => $this->faker->time(),
            'official_end_time' => $this->faker->time(),
            'detail' => $this->faker->text(),
        ];
    }
}
