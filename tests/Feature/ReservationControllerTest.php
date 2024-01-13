<?php

namespace Tests\Feature;

use App\Models\Event;
use App\Models\Venue;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ReservationControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_reserving_tickets_for_event(): void
    {
        $user = User::factory()->create();
        Venue::factory()->create();
        $event = Event::factory()->create();

        $reservationData = $this->createReservationDataForEvent($event);

        $response = $this->actingAs($user)->postJson(route('reservation'), $reservationData);

        $response->assertStatus(200)
            ->assertJson(['status' => 'booking successful']);

        $this->assertDatabaseHas('tickets', [
            'event_id' => $event->id,
        ]);
    }

    private function createReservationDataForEvent(Event $event): array
    {
        return [
            'events' => [
                [
                    'id' => $event->id,
                    'seats' => [
                        ['type' => 'standard'],
                    ],
                ],
            ],
        ];
    }
}
