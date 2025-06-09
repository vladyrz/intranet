<?php

namespace App\Jobs;

use App\Mail\HappyBirthdayMail;
use App\Models\Employee;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class SendBirthdayEmailJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $tomorrow = \Carbon\Carbon::tomorrow();

        $employees = Employee::whereMonth('birthday', $tomorrow->month)
            ->whereDay('birthday', $tomorrow->day)
            ->get();

        foreach ($employees as $employee) {
            Mail::to($employee->email)->queue(new HappyBirthdayMail($employee));
        }
    }
}
