<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use App\Models\QuizAttempt;
use App\Http\Controllers\QuizController;


class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     */
    // Di app/Console/Kernel.php
protected function schedule(Schedule $schedule)
{
    $schedule->call(function () {
        $expiredAttempts = QuizAttempt::whereNull('finished_at')
            ->where('time_remaining', '<=', 0)
            ->get();

        foreach ($expiredAttempts as $attempt) {
            $quizController = new QuizController();
            $quizController->autoSubmitQuiz($attempt->quiz, $attempt);
        }
    })->everyMinute();
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
