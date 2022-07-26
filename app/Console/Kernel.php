<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        /** Atualiza os jogos do brasileirão, a cada hora. */
        $schedule->command("atualiza:jogos-brasileirao")
            ->hourly()
            ->runInBackground();

        /** Atualiza a tabela do brasileirão, a cada 5 minutos. */
        $schedule->command("atualiza:tabela-brasileirao")
            ->everyFiveMinutes()
            ->runInBackground();

        /** Atualiza estatísticas dos jogos do brasileirão, todos os dias a meia-noite. */
        $schedule->command("salva-detalhes:jogos-brasileirao")
            ->daily()
            ->runInBackground();
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

    /**
     * Get the timezone that should be used by default for scheduled events.
     *
     * @return \DateTimeZone|string|null
     */
    protected function scheduleTimezone()
    {
        return 'America/Sao_Paulo';
    }
}
