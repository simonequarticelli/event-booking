<?php

namespace App\Services;

use App\Models\Event;
use App\Models\Ticket;
use App\Models\TicketState;
use App\Models\Transaction;
use App\Repositories\Ticket\TicketRepository;
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

    public function processEvent(array $event, Transaction $transaction, float &$totalPrice): void
    {
        $ticketRepository = new TicketRepository();
        $seatsQuantity = count($event['seats']);

        $this->validateByOptionsConfig($seatsQuantity);
        $this->availabilityCheck($seatsQuantity);


        foreach ($event['seats'] as $seat) {
            $totalPrice = $totalPrice + $this->getPriceByType($seat['type']);

            $ticketRepository->save([
                'event_id' => $event['id'],
                'ticket_state_id' => TicketState::where('slug', TicketState::PENDING)->first()->id,
                'transaction_id' => $transaction->id,
                'price' => $this->getPriceByType($seat['type']),
                'barcode' => fake()->isbn13(),
                'expires_at' => Event::find($event['id'])->first()->end_date,
            ]);
        }
    }
}
