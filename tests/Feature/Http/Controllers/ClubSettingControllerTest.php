<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\ClubSetting;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use JMac\Testing\Traits\AdditionalAssertions;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

/**
 * @see \App\Http\Controllers\ClubSettingController
 */
final class ClubSettingControllerTest extends TestCase
{
    use AdditionalAssertions, RefreshDatabase, WithFaker;

    #[Test]
    public function index_behaves_as_expected(): void
    {
        $clubSettings = ClubSetting::factory()->count(3)->create();

        $response = $this->get(route('club-settings.index'));
    }


    #[Test]
    public function store_uses_form_request_validation(): void
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\ClubSettingController::class,
            'store',
            \App\Http\Requests\ClubSettingStoreRequest::class
        );
    }

    #[Test]
    public function store_saves_and_redirects(): void
    {
        $club_name = $this->faker->word();

        $response = $this->post(route('club-settings.store'), [
            'club_name' => $club_name,
        ]);

        $clubSettings = ClubSetting::query()
            ->where('club_name', $club_name)
            ->get();
        $this->assertCount(1, $clubSettings);
        $clubSetting = $clubSettings->first();

        $response->assertRedirect(route('clubSetting.index'));
    }


    #[Test]
    public function show_displays_view(): void
    {
        $clubSetting = ClubSetting::factory()->create();

        $response = $this->get(route('club-settings.show', $clubSetting));

        $response->assertOk();
        $response->assertViewIs('club_setting');
    }
}
