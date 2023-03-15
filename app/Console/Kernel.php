<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use App\Jobs\BirthdayGreeting;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        Commands\CleanTempDirectory::class,
        Commands\ChangeStaffStatus::class,
        Commands\ChangeProgrammmingStatus::class,
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        /* TODO: Esto es para el servidor azul, se tiene que eliminar cuando esté funcionando en Cloud Run, que está en el else */
        if(env('OLD_SERVER')){
            $schedule->command('clean:tempDir')->daily();
            $schedule->command('change:proStatus')->yearlyOn(12, 16, '00:00');
        }else{
            /* TODO: Esto es para la versión en Cloud Run (Verde) */
            $schedule->command('command:birthdayGretting')->dailyAt('08:30');
            $schedule->command('change:staffStatus')->daily();
        }
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
