<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TicketResource extends JsonResource
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
            'event' => new EventResource($this->event),
            'state' => new TicketStateResource($this->state),
            'transaction' => new TransactionResource($this->transaction),
            'price' => $this->price,
            'barcode' => $this->barcode,
            'expires_at' => $this->expires_at,
            'used_at' => $this->used_at,
            'cancelled_at' => $this->cancelled_at,
        ];
    }
}
