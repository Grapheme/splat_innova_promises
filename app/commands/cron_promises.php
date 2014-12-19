<?php

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

class CronPromises extends Command {

	/**
	 * The console command name.
	 *
	 * @var string
	 */
	protected $name = 'promises:notices';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'Напоминания о завершающихся и проваленных обещаниях';

	/**
	 * Create a new command instance.
	 */
	public function __construct() {
		parent::__construct();
	}

	/**
	 * Execute the console command.
	 *
	 * @return mixed
	 */
	public function fire() {

		#$this->info("111");

		$now = (new \Carbon\Carbon())->now();
		$yesterday = (new \Carbon\Carbon())->yesterday(); // вчера
		$tomorrow = (new \Carbon\Carbon())->tomorrow(); // завтра

		$promises = Dic::valuesBySlug('promises', function($query) use ($yesterday, $now){

			$tbl_dicval = (new DicVal())->getTable();
			$tbl_dic_field_val = (new DicFieldVal())->getTable();
			$rand_tbl_alias = md5(time() . rand(999999, 9999999));

			$query->join($tbl_dic_field_val . ' AS ' . $rand_tbl_alias, $rand_tbl_alias . '.dicval_id', '=', $tbl_dicval . '.id')
				->where($rand_tbl_alias . '.key', '=', 'time_limit')
				->where($rand_tbl_alias . '.value', '>', $yesterday->format('Y-m-d H:i:s'))
				->where($rand_tbl_alias . '.value', '<', $now->format('Y-m-d H:i:s'))
			;

		});

		$promises = DicVal::extracts($promises, true, true);

		//$temp = Dic::all();
		Helper::tad($promises);
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
