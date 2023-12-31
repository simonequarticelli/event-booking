<?php

namespace App\Http\Controllers;

use App\Models\TransactionState;
use App\Services\UserService;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Throwable;

class PayController extends Controller
{
    public function __construct(
        public UserService $userService,
    ) {}

    public function __invoke(): JsonResponse
    {
        DB::beginTransaction();
        try {
            try {
                $randomIndex = fake()->numberBetween(0, 1);
                $states = [TransactionState::APPROVED, TransactionState::REJECTED];
                $message = $randomIndex ? 'the transaction was rejected' : 'purchase completed successfully';

                $pendingTransaction = $this->userService->pendingTransaction()->first();
                if (empty($pendingTransaction)) {
                    return response()->json(['error' => 'no transactions found'], 404);
                }

                $pendingTransaction->update([
                    'transaction_state_id' => TransactionState::firstWhere('slug', $states[$randomIndex])->id
                ]);

            } catch (Throwable $e) {
                return response()->json(['error' => $e->getMessage()], 404);
            }
            DB::commit();
        }  catch (Exception $e) {
            DB::rollback();
            Log::error($e->getMessage());
            return response()->json(['error' => 'Something went wrong. Please try again.'], 404);
        }

        return response()->json(['status' => $message]);
    }
}
