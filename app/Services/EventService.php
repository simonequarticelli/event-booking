<?php

namespace App\Services;

use App\Models\Event;
use Exception;
use Throwable;

class EventService
{
    private $event;

    public function __construct(int $id)
    {
        $this->event = Event::find($id);
    }

    /**
     * @throws Throwable
     */
    public function validateByOptionsConfig(int $seatsQuantity): void
    {
        throw_if(
            $seatsQuantity > $this->event->option->max_tickets_for_transaction,
            Exception::class,
            "No more than {$this->event->option->max_tickets_for_transaction} tickets per event may be booked per transaction."
        );
    }

    /**
     * @throws Throwable
     */
    public function availabilityCheck(int $seatsQuantity): void
    {
        throw_if(
            $seatsQuantity > $this->event->tickets_available,
            Exception::class,
            "The availability for this event is {$this->event->tickets_available} tickets."
        );
    }

    public function getPriceByType(string $type)
    {
        return $this->event->price[$type];
    }
}
