<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use Illuminate\Support\Facades\Log;



class Kernel extends ConsoleKernel
{
    /**
     * Define your application's command schedule.
     */
    protected function schedule(Schedule $schedule): void
    {
        // Check unpaid utang due today or earlier and send reminder
        $schedule->call(function () {
            $due = \App\Models\Utang::with('customer')
                ->where('status', 'Unpaid')
                ->whereDate('due_date', '<=', today())
                ->get();

            foreach ($due as $u) {
                Log::info("Utang reminder for {$u->customer->name}, amount: {$u->amount}");
            }
        })->daily(); // Change to everyMinute() while testing
    }

    /**
     * Register the commands for the application.
     */
    protected function commands(): void
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
