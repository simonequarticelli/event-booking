<?php

namespace App\Http\Controllers;

use App\Http\Requests\ReservationRequest;
use App\Models\Event;
use App\Models\Ticket;
use App\Models\TicketState;
use App\Models\Transaction;
use App\Models\TransactionState;
use App\Models\User;
use App\Services\EventService;
use App\Services\UserService;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Throwable;

class ReservationController extends Controller
{
    private UserService $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    /**
     * Handle the incoming request.
     * @throws Exception
     */
    public function __invoke(ReservationRequest $request): JsonResponse
    {
        $events = $request->safe()->events;

        DB::beginTransaction();
        try {
            try {
                $activeTransaction = $this->userService->getActiveTransaction();

                if ($activeTransaction === null) {
                    $transaction = Transaction::create([
                        // 'user_id' => auth()->id(),
                        'user_id' => 1,
                        'transaction_state_id' => TransactionState::where('slug', TransactionState::PENDING)->first()->id,
                        'amount' => 0,
                    ]);
                } else {
                    $transaction = $activeTransaction;
                }

                $totalPrice = 0.00;
                foreach ($events as $event) {
                    $eventService = new EventService($event['id']);
                    $seatsQuantity = count($event['seats']);

                    $eventService->validateByOptionsConfig($seatsQuantity);
                    $eventService->availabilityCheck($seatsQuantity);


                    foreach ($event['seats'] as $seat) {
                        $totalPrice = $totalPrice+$eventService->getPriceByType($seat['type']);

                        Ticket::create([
                            'event_id' => $event['id'],
                            'ticket_state_id' => TicketState::where('slug', TicketState::PENDING)->first()->id,
                            'transaction_id' => $transaction->id,
                            'price' => $eventService->getPriceByType($seat['type']),
                            'barcode' => fake()->isbn13(),
                            'expires_at' => Event::find($event['id'])->first()->end_date,
                        ]);
                    }
                }

                $transaction->increment('amount', $totalPrice);
            }  catch (Throwable $e) {
                return response()->json(['error' => $e->getMessage()], 404);
            }
            DB::commit();
        } catch (Exception $e) {
            DB::rollback();
            Log::error($e->getMessage());
            return response()->json(['error' => 'Something went wrong. Please try again.'], 404);
        }

        // TODO: event

        return response()->json(['status' => 'booking successful']);
    }
}
