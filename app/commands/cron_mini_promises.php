<?php

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

class CronMiniPromises extends Command {

	/**
	 * The console command name.
	 *
	 * @var string
	 */
	protected $name = 'minipromises:notices';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'Напоминания о коротких обещаниях (до 48 часов)';

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

		$only_email = false;
		#$only_email = 'reserved@mail.ru';
		$only_email = $this->option('only_email');

        $this->periods = Config::get('site.notify_periods');

        $debug = $this->argument('debug') ?: false;

		if ($debug)
			$this->info('RUN IN DEBUG MODE - MAILs WILL NOT BE SEND');

		if ($only_email)
			$this->info('Mails will be send only to: ' . $only_email);

		$this->info('System time: ' . date('Y-m-d H:i:s'));


		#die;


		/************************************************************************************************************ */


		$now = (new \Carbon\Carbon())->now(); // сейчас

		$yesterday3 = clone $now;
		$yesterday3->subHours(24*3); // 3 дня назад

		$yesterday2 = clone $now;
		$yesterday2->subHours(48); // позавчера

		$yesterday = clone $now;
		$yesterday->subHours(24); // вчера

		$tomorrow = clone $now;
		$tomorrow->addHours(24); // завтра

		$tomorrow2 = clone $now;
		$tomorrow2->addHours(48); // послезавтра


		$also_users = array();

		/************************************************************************************************************ */


		/**
		 * Получаем мини обещания
		 */
		$promises = Dic::valuesBySlug('promises', function($query) use ($yesterday2, $tomorrow2){

			$tbl_dicval = (new DicVal())->getTable();
			$tbl_dic_field_val = (new DicFieldVal())->getTable();

			$rand_tbl_alias = md5(time() . rand(999999, 9999999));
			$query->join(DB::raw('`' . $tbl_dic_field_val . '` AS `' . $rand_tbl_alias . '`'), function ($join) use ($rand_tbl_alias, $tbl_dicval, $yesterday2, $tomorrow2) {
				$join
					->on($rand_tbl_alias . '.dicval_id', '=', $tbl_dicval . '.id')
					->where($rand_tbl_alias . '.key', '=', 'time_limit')
					->where($rand_tbl_alias . '.created_at', '>=', $yesterday2->format('Y-m-d H:i:s'))
					->where($rand_tbl_alias . '.value', '<', $tomorrow2->format('Y-m-d H:i:s'))
				;
			});
			$query
				->addSelect(DB::raw('`' . $rand_tbl_alias . '`.`value` AS time_limit'))
			;
		});
		#Helper::smartQueries(1);
		$promises = DicVal::extracts($promises, null, true, true);
		Helper::ta($promises);
		$this->info('Total mini promises: ' . count($promises));

		#die;

		/**
		 * Если что-то найдено...
		 */
		if (count($promises)) {

			/**
			 * Фильтруем просроченные обещания:
			 * - оставляем только те, у которых нет явной метки "выполнено" или "провалено"
			 * - оставляем только те, у которых прошла ~половина срока, т.е.
			 * [текущее время] <= ([время создания обещания] + 0,5 * [общая длительность обещания]) < [текущее время] + 1 час
			 */
			foreach ($promises as $p => $promise) {

				if ($promise->finished_at || $promise->promise_fail) {

					unset($promises[$p]);
					continue;
				}

				/*
				 * Получаем время создания обещания, временной лимит на выполнение обещания,
				 * вычисляем общее время на обещание в секундах, и находим временную метку,
				 * при которой прошла половина срока обещания.
				 * Далее проверяем, попадает ли она в отведенный временной промежуток (в зависимости от текущего времени).
				 */
				$promise_carbon_start = \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $promise->created_at);
				$promise_carbon_limit = \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $promise->time_limit);
				$promise_length = $promise_carbon_limit->timestamp - $promise_carbon_start->timestamp;

				Helper::ta($promise_length);

				$promise_halftime_mark = $promise_carbon_start->timestamp + ceil($promise_length/2);

				#$this->info($promise_halftime_mark . " >= \n" . time() . "\n && \n" . $promise_halftime_mark . " < \n" . (time()+60*60));
				$this->info(
					\Carbon\Carbon::createFromTimestamp($promise_halftime_mark)->format('Y-m-d H:i:s')
					. " >= \n"
					. \Carbon\Carbon::now()->format('Y-m-d H:i:s')
					. "\n && \n"
					. \Carbon\Carbon::createFromTimestamp($promise_halftime_mark)->format('Y-m-d H:i:s')
					. " < \n"
					. \Carbon\Carbon::now()->addHours(1)->format('Y-m-d H:i:s')
				);

				if ($promise_halftime_mark >= time() && $promise_halftime_mark < (time()+60*60)) {
					#
				} else {

					unset($promises[$p]);
					continue;
				}
			}
			$this->info('Filtered promises: ' . count($promises));

			$promises_ids = Dic::makeLists($promises, NULL, 'id');
			Helper::d($promises_ids);

			#die;

			/**
			 * Получаем ID пользователей - авторов обещаний
			 */
			$users_ids = Dic::makeLists($promises, NULL, 'user_id');
			$this->info('Total users: ' . count($users_ids));
			Helper::d($users_ids);

			$users_ids = array_unique($users_ids);
			$this->info('Filtered (unique) users: ' . count($users_ids));
			Helper::d($users_ids);

			/**
			 * Загружаем пользователей по IDs
			 */
			if (count($users_ids)) {

				$users = Dic::valuesBySlugAndIds('users', $users_ids);
				$users = DicVal::extracts($users, NULL, true, true);
				$this->info('Users objects: ' . count($users));
				#Helper::ta($users);

				$this->info('Отправляем письма с оповещением о скором истечени срока миниобещания...');

				/**
				 * Если есть юзеры, которым нужно отправить оповещение...
				 */
				if (count($users)) {

					/**
					 * Перебираем всех юзеров
					 */
					foreach ($users as $u => $user) {

						/**
						 * Если юзеру уже было отправлено письмо раньше - не будем отправлять
						 */
						if (in_array($user->id, $also_users)) {
							continue;
						}

                        $user->notifications = json_decode($user->notifications, true);

                        /**
                         * Смотрим на выбранную частоту обновлений и метку отправки последнего уведомления
                         * и решаем, прошел ли выбранный срок или нет.
                         */
                        $subSeconds = @(int)$this->periods[$user->notifications['notify_period']];
                        $period_finish = ($user->last_notification + $subSeconds) < time();
                        if (!$period_finish)
                            continue;

                        /**
						 * Запомним юзера, чтобы не отправлять ему больше, чем одно письмо
						 */
						$also_users[] = $user->id;


						$data = array(
							#'promise' => $promise,
							'user' => $user,
						);

                        /**
                         * Если не DEBUG режим...
                         */
                        if (!$debug) {

                            /**
                             * Отправка уведомлений на почту...
                             */
                            if (!$only_email || $only_email == $user->email) {

                                /**
                                 * Валидация - установлен ли валидный адрес почты
                                 */
                                $validator = Validator::make(array('email' => $user->email), array('email' => 'required|email'));

                                /**
                                 * - если прошла валидация почты
                                 * - если юзер хочет получать напоминания о сроках своего обещания
                                 * - если юзер хочет получать уведомления на почту
                                 */
                                if (!$validator->fails() && @$user->notifications['promise_dates'] && @$user->notifications['on_email']) {

                                    Mail::send('emails.cron_promise_expire', $data, function ($message) use ($user) {
                                        $from_email = Config::get('mail.from.address');
                                        $from_name = Config::get('mail.from.name');
                                        $message->from($from_email, $from_name);
                                        $message->subject('Заканчивается срок выполнения обещания!');
                                        $message->to($user->email);
                                    });

                                    /**
                                     * Обновляем время последней отправки уведомлений
                                     */
                                    $user->update_field('last_notification', time());

                                    $this->info(' + ' . $user->email);
                                }
                            }
                        }
					}
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
			array('debug', InputArgument::OPTIONAL, 'Debug or not debug.', null),
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
			array('only_email', null, InputOption::VALUE_OPTIONAL, 'Only email option.', null),
		);
	}

}

