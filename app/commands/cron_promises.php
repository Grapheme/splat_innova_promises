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
		date_default_timezone_set("Europe/Moscow");
	}

	/**
	 * Execute the console command.
	 *
	 * @return mixed
	 */
	public function fire() {

		#$this->info("111");

		$now = (new \Carbon\Carbon())->now();

		#$yesterday = (new \Carbon\Carbon())->yesterday(); // вчера
		$yesterday = clone $now;
		$yesterday->subDay(1); // вчера

		#$tomorrow = (new \Carbon\Carbon())->tomorrow(); // завтра
		$tomorrow = clone $now;
		$tomorrow->addDay(1); // завтра

		$tomorrow2 = clone $now;
		$tomorrow2->addDay(2); // послезавтра

		/**
		 * Получаем проваленные обещания
		 */
		$promises = Dic::valuesBySlug('promises', function($query) use ($yesterday, $now){

			$tbl_dicval = (new DicVal())->getTable();
			$tbl_dic_field_val = (new DicFieldVal())->getTable();

			$rand_tbl_alias = md5(time() . rand(999999, 9999999));
			$query->join(DB::raw('`' . $tbl_dic_field_val . '` AS `' . $rand_tbl_alias . '`'), function ($join) use ($rand_tbl_alias, $tbl_dicval, $yesterday, $now) {
				$join
					->on($rand_tbl_alias . '.dicval_id', '=', $tbl_dicval . '.id')
					#->orOn(...)
					->where($rand_tbl_alias . '.key', '=', 'time_limit')
					->where($rand_tbl_alias . '.value', '>', $yesterday->format('Y-m-d H:i:s'))
					->where($rand_tbl_alias . '.value', '<', $now->format('Y-m-d H:i:s'))
				;
			});
			$query
				->addSelect(DB::raw($rand_tbl_alias . '.value AS time_limit'))
			;
		});
		#Helper::smartQueries(1);

		$promises = DicVal::extracts($promises, NULL, true, true);
		#Helper::ta($promises);
		$this->info('Total failed promises: ' . count($promises));

		if (count($promises)) {

			/**
			 * Фильтруем обещания - оставляем только невыполненные и непроваленные
			 */
			foreach ($promises as $p => $promise) {

				if ($promise->finished_at || $promise->promise_fail)
					unset($promises[$p]);
			}
			$this->info('Filtered promises: ' . count($promises));

			/**
			 * Получаем ID пользователей
			 */
			$users_ids = Dic::makeLists($promises, NULL, 'user_id');
			$this->info('Total users: ' . count($users_ids));
			Helper::d($users_ids);

			$users_ids = array_unique($users_ids);
			$this->info('Filtered users: ' . count($users_ids));
			Helper::d($users_ids);

			/**
			 * Загружаем пользователей по ID
			 */
			$users = Dic::valuesBySlugAndIds('users', $users_ids);
			$users = DicVal::extracts($users, NULL, true, true);
			$this->info('Users objects: ' . count($users));
			#Helper::ta($users);

			$also_users = array();

			$this->info('Отправляем письма с оповещением о проваленных обещаниях...');

			if (count($users)) {

				/**
				 * Перебираем всех юзеров
				 */
				foreach ($users as $u => $user) {

					$also_users[] = $user->id;

					/**
					 * Валидация
					 */
					$validator = Validator::make(array('email' => $user->email), array('email' => 'required|email'));
					if ($validator->fails()) {
						continue;
					}

					/**
					 * Если валидация пройдена - отправляем письмо
					 */
					$data = array(
						#'promise' => $promise,
						'user' => $user,
					);
					Mail::send('emails.cron_promise_fail', $data, function ($message) use ($user) {
						$from_email = Config::get('mail.from.address');
						$from_name = Config::get('mail.from.name');
						$message->from($from_email, $from_name);
						$message->subject('Не удалось выполнить обещание');
						$message->to($user->email);
					});
					$this->info($user->email);
				}
			}
		}




		/************************************************************************************************************ */


		$this->info('###################################################################');


		/**
		 * Получаем истекающие обещания
		 */
		$promises = Dic::valuesBySlug('promises', function($query) use ($now, $tomorrow, $tomorrow2){

			$tbl_dicval = (new DicVal())->getTable();
			$tbl_dic_field_val = (new DicFieldVal())->getTable();

			$rand_tbl_alias = md5(time() . rand(999999, 9999999));
			$query->join(DB::raw('`' . $tbl_dic_field_val . '` AS `' . $rand_tbl_alias . '`'), function ($join) use ($rand_tbl_alias, $tbl_dicval, $now, $tomorrow, $tomorrow2) {
				$join
					->on($rand_tbl_alias . '.dicval_id', '=', $tbl_dicval . '.id')
					#->orOn(...)
					->where($rand_tbl_alias . '.key', '=', 'time_limit')
					->where($rand_tbl_alias . '.value', '>', $tomorrow->format('Y-m-d H:i:s'))
					->where($rand_tbl_alias . '.value', '<', $tomorrow2->format('Y-m-d H:i:s'))
				;
			});
			$query
				->addSelect(DB::raw($rand_tbl_alias . '.value AS time_limit'))
			;
		});
		#Helper::smartQueries(1);

		$promises = DicVal::extracts($promises, NULL, true, true);
		#Helper::ta($promises);
		$this->info('Total expired promises: ' . count($promises));

		if (count($promises)) {

			/**
			 * Фильтруем обещания - оставляем только невыполненные и непроваленные
			 */
			foreach ($promises as $p => $promise) {

				if ($promise->finished_at || $promise->promise_fail) {
					unset($promises[$p]);
				}
			}
			$this->info('Filtered promises: ' . count($promises));

			/**
			 * Получаем ID пользователей
			 */
			$users_ids = Dic::makeLists($promises, NULL, 'user_id');
			$this->info('Total users: ' . count($users_ids));
			Helper::d($users_ids);

			$users_ids = array_unique($users_ids);
			$this->info('Filtered users: ' . count($users_ids));
			Helper::d($users_ids);

			/**
			 * Загружаем пользователей по ID
			 */
			$users = Dic::valuesBySlugAndIds('users', $users_ids);
			$users = DicVal::extracts($users, NULL, true, true);
			$this->info('Users objects: ' . count($users));
			#Helper::ta($users);

			$this->info('Отправляем письма с оповещением об истекающих обещаниях...');

			if (count($users)) {

				/**
				 * Перебираем всех юзеров
				 */
				foreach ($users as $u => $user) {

					if (in_array($user->id, $also_users)) {
						continue;
					}

					/**
					 * Валидация
					 */
					$validator = Validator::make(array('email' => $user->email), array('email' => 'required|email'));
					if ($validator->fails()) {
						continue;
					}

					/**
					 * Если валидация пройдена - отправляем письмо
					 */
					$data = array(#'promise' => $promise,
						'user' => $user,);
					Mail::send('emails.cron_promise_expire', $data, function ($message) use ($user) {
						$from_email = Config::get('mail.from.address');
						$from_name = Config::get('mail.from.name');
						$message->from($from_email, $from_name);
						$message->subject('Заканчивается срок выполнения обещания!');
						$message->to($user->email);
					});
					$this->info($user->email);
				}
			}
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
