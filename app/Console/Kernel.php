<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
	protected function schedule(Schedule $schedule)
	{
		$schedule->command('send:download_order_best_shipping')->everyMinute()->withoutOverlapping();
		$schedule->command('send:download_events_order')->everyMinute()->withoutOverlapping();
		$schedule->command('send:send_msg_one_guest')->everyMinute()->withoutOverlapping();
		$schedule->command('send:send_msg_two_guest')->everyMinute()->withoutOverlapping();
		$schedule->command('send:send_msg_three_guest')->everyMinute()->withoutOverlapping();
		$schedule->command('send:send_msg_four_guest')->everyMinute()->withoutOverlapping();
		$schedule->command('send:send_msg_five_guest')->everyMinute()->withoutOverlapping();
		$schedule->command('send:send_msg_six_guest')->everyMinute()->withoutOverlapping();
	}
	
	protected function commands()
	{
		$this->load(__DIR__.'/Commands');
		require base_path('routes/console.php');
	}
}
