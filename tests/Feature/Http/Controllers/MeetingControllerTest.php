<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\Meeting;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use JMac\Testing\Traits\AdditionalAssertions;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

/**
 * @see \App\Http\Controllers\MeetingController
 */
final class MeetingControllerTest extends TestCase
{
    use AdditionalAssertions, RefreshDatabase, WithFaker;

    #[Test]
    public function index_behaves_as_expected(): void
    {
        $meetings = Meeting::factory()->count(3)->create();

        $response = $this->get(route('meetings.index'));
    }


    #[Test]
    public function store_uses_form_request_validation(): void
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\MeetingController::class,
            'store',
            \App\Http\Requests\MeetingStoreRequest::class
        );
    }

    #[Test]
    public function store_saves_and_redirects(): void
    {
        $type = $this->faker->word();
        $date = $this->faker->dateTime();
        $venue = $this->faker->word();
        $topic = $this->faker->word();
        $host = $this->faker->text();
        $official_start_time = $this->faker->text();
        $official_end_time = $this->faker->text();

        $response = $this->post(route('meetings.store'), [
            'type' => $type,
            'date' => $date,
            'venue' => $venue,
            'topic' => $topic,
            'host' => $host,
            'official_start_time' => $official_start_time,
            'official_end_time' => $official_end_time,
        ]);

        $meetings = Meeting::query()
            ->where('type', $type)
            ->where('date', $date)
            ->where('venue', $venue)
            ->where('topic', $topic)
            ->where('host', $host)
            ->where('official_start_time', $official_start_time)
            ->where('official_end_time', $official_end_time)
            ->get();
        $this->assertCount(1, $meetings);
        $meeting = $meetings->first();

        $response->assertRedirect(route('meetings.index'));
    }


    #[Test]
    public function show_displays_view(): void
    {
        $meeting = Meeting::factory()->create();

        $response = $this->get(route('meetings.show', $meeting));

        $response->assertOk();
        $response->assertViewIs('meeting');
    }
}
