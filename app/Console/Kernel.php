<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
	protected function schedule(Schedule $schedule)
	{
		$schedule->command('send:download_order_best_shipping')->everyMinute()->withoutOverlapping();
		$schedule->command('send:download_order_nuvem_shop')->everyMinute()->withoutOverlapping();
		$schedule->command('send:download_events_order')->everyMinute()->withoutOverlapping();
		
		$schedule->command('send:send_msg_one_guest')->everyMinute()
		->timezone('America/Sao_Paulo')
    ->between('08:00', '18:00')
		->withoutOverlapping();
		/*
		$schedule->command('send:send_msg_two_guest')->hours([8, 9, 10, 11, 12])->withoutOverlapping();
		$schedule->command('send:send_msg_three_guest')->hours([8, 9, 10, 11, 12])->withoutOverlapping();
		$schedule->command('send:send_msg_four_guest')->hours([8, 9, 10, 11, 12])->withoutOverlapping();
		$schedule->command('send:send_msg_five_guest')->hours([8, 9, 10, 11, 12])->withoutOverlapping();
		$schedule->command('send:send_msg_six_guest')->hours([8, 9, 10, 11, 12])->withoutOverlapping(); 
		*/
	}
	
	protected function commands()
	{
		$this->load(__DIR__.'/Commands');
		require base_path('routes/console.php');
	}
}
