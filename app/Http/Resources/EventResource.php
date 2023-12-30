<?php

namespace App\Http\Resources;

use App\Models\Event;
use App\Models\Ticket;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class EventResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'description' => $this->description,
            'seats' => $this->seats,
            'venue' => new VenueResource($this->venue),
            'start_date' => $this->start_date,
            'end_date' => $this->end_date,
            'image' => $this->image,
            'social_link' => $this->social_link,
            'tickets_available' => $this->tickets_available
        ];
    }
}
