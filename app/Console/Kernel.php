<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
	protected function schedule(Schedule $schedule)
	{
		$schedule->command('send:download_order_best_shipping')->everyThirtyMinutes()->withoutOverlapping();
		$schedule->command('send:download_order_nuvem_shop')->everyThirtyMinutes()->withoutOverlapping();
		$schedule->command('send:download_events_order')->everyFifteenMinutes()->withoutOverlapping();
		$schedule->command('send:send_msg_one_guest')->everyMinute()->between('08:00', '13:00')->withoutOverlapping();
		$schedule->command('send:send_msg_two_guest')->hourly()->between('08:00', '12:00')->withoutOverlapping();
		$schedule->command('send:send_msg_three_guest')->hourly()->between('08:00', '12:00')->withoutOverlapping();
		$schedule->command('send:send_msg_four_guest')->hourly()->between('08:00', '12:00')->withoutOverlapping();
		$schedule->command('send:send_msg_five_guest')->hourly()->between('08:00', '12:00')->withoutOverlapping();
		$schedule->command('send:send_msg_six_guest')->hourly()->between('08:00', '12:00')->withoutOverlapping();
	}
	
	protected function commands()
	{
		$this->load(__DIR__.'/Commands');
		require base_path('routes/console.php');
	}
}
