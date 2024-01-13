<?php

namespace App\Http\Controllers;

use App\Http\Requests\ReservationRequest;
use App\Services\EventService;
use App\Services\TransactionService;
use App\Services\UserService;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Throwable;

class ReservationController extends Controller
{
    public function __construct(
        public UserService $userService,
        public TransactionService $transactionService,
        public EventService $eventService,
    ) {}

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
                $pendingTransaction = $this->userService->pendingTransaction()->first();
                $transaction = $this->transactionService->getOrCreateTransaction($pendingTransaction);

                $totalPrice = 0.00;
                foreach ($events as $event) {
                    $this->eventService->processEvent($event, $transaction, $totalPrice);
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

        return response()->json(['status' => 'booking successful']);
    }
}
