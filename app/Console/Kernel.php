<?php

namespace App\Console;

use App\Models\AfyachapUsersAccount;
use Carbon\Carbon;
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
<<<<<<< HEAD
       
=======
        
>>>>>>> origin/main
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        // $schedule->command('inspire')->hourly();
        $schedule->command('check-failure-payment')->daily();

<<<<<<< HEAD
       
=======
        $schedule->call(function () {
            $users = AfyachapUsersAccount::where('valid_to', '<=', Carbon::now())->get();

            foreach ($users as $user) {
                //Update each application as you want to
                $user->user_account_type = 'FREE';
                $user->save();
            }

        })->daily();
>>>>>>> origin/main

    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__ . '/Commands');

        require base_path('routes/console.php');
    }
}