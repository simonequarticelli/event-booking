<?php

namespace App\Http\Controllers;

use App\Models\TransactionState;
use App\Services\TicketingService;
use App\Services\UserService;
use Throwable;

class PayController extends Controller
{
    private UserService $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    public function __invoke()
    {
        try {
            $randomIndex = fake()->numberBetween(0, 1);
            $states = [TransactionState::APPROVED, TransactionState::CANCELLED];

            $this->userService->pendingTransaction()->first()->update([
                'state_id' => TransactionState::find(TransactionState::WAITING_FOR_APPROVAL)->id
            ]);

            sleep(20);

            $this->userService->pendingTransaction()->first()->update([
                'state_id' => TransactionState::find($states[$randomIndex])->id
            ]);

        } catch (Throwable $e) {
            return response()->json(['error' => $e->getMessage()], 404);
        }

        return response()->json(['status' => 'purchase completed successfully']);
    }
}
