<?php

namespace App\Console;

use App\Console\Commands\TransferFromDBToRedisCommand;
use App\Console\Commands\TransferFromRedisToDBCommand;
use App\Models\Fond;
use App\Models\Operation;
use App\Models\UserOperation;
use App\Models\Users;
use App\Models\UserStatus;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        TransferFromDBToRedisCommand::class,
        TransferFromRedisToDBCommand::class,
    ];

    /**
     * Define the application's command schedule.
     *
     * @param \Illuminate\Console\Scheduling\Schedule $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
    }

    /**
     * Register the Closure based commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        require base_path('routes/console.php');
    }
}
