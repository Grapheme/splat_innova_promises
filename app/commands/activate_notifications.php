<?php

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

class ActivateNotifications extends Command {

	/**
	 * The console command name.
	 *
	 * @var string
	 */
	protected $name = 'promises:activate_notifications';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'Включить всем пользователям рассылку уведомлений';

	/**
	 * Create a new command instance.
	 */
	public function __construct() {
		parent::__construct();
		date_default_timezone_set("Europe/Moscow");
	}

	/**
	 * Execute the console command.
	 *
	 * @return mixed
	 */
	public function fire() {

		#$this->info("111");

		$users = Dic::valuesBySlug('users');
		foreach ($users as $user) {
			$user->update_field('notifications', '{"new_comment":"1","promise_dates":"1","promise_status":"1"}');
		}

		die;
	}

	/**
	 * Get the console command arguments.
	 *
	 * @return array
	 */
	protected function getArguments() {
		return array(
			#array('example', InputArgument::REQUIRED, 'An example argument.'),
		);
	}

	/**
	 * Get the console command options.
	 *
	 * @return array
	 */
	protected function getOptions() {
		return array(
			#array('example', null, InputOption::VALUE_OPTIONAL, 'An example option.', null),
		);
	}

}
