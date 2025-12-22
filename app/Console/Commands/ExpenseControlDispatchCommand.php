<?php

namespace App\Console\Commands;

use App\Enums\ExpenseStatus;
use App\Jobs\SendExpenseControlJob;
use App\Models\ExpenseControl;
use Illuminate\Console\Command;

class ExpenseControlDispatchCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'expense-control:dispatch';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Dispatch active expense control alerts that are due for payment/notification.';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $now = now('America/Costa_Rica');

        $this->info("Checking for expenses due before: " . $now->toDateTimeString());

        $expenses = ExpenseControl::query()
            ->where('status', ExpenseStatus::Active)
            ->where(function ($query) use ($now) {
                $query->where('next_run_at', '<=', $now)
                    ->orWhere(function ($sub) use ($now) {
                        // Fallback: checks payment_date if next_run_at is somehow null but valid
                        $sub->whereNull('next_run_at')
                            ->where('payment_date', '<=', $now->toDateString());
                    });
            })
            ->get();

        $count = $expenses->count();
        $this->info("Found {$count} expenses due.");

        foreach ($expenses as $expense) {
            // Dispatch job
            SendExpenseControlJob::dispatch($expense);
            $this->info("Dispatched expense ID: {$expense->id} - {$expense->description}");
        }

        return Command::SUCCESS;
    }
}
