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

		$only_email = false;
		#$only_email = 'reserved@mail.ru';
		$only_email = $this->option('only_email');

        $this->periods = Config::get('site.notify_periods');

        $debug = $this->argument('debug') ?: false;
        $only_sms_number = $this->option('only_sms_number') ?: false;

        $this->info('Start to work...');

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


        $this->info('Получаем полностью проваленные обещания...');

        /**
		 * Получаем полностью проваленные обещания
		 * 3 ДНЯ НАЗАД - ВЧЕРА
		 */
		$promises = Dic::valuesBySlug('promises', function($query) use ($yesterday3, $yesterday){

			$tbl_dicval = (new DicVal())->getTable();
			$tbl_dic_field_val = (new DicFieldVal())->getTable();

			$rand_tbl_alias = md5(time() . rand(999999, 9999999));
			#$rand_tbl_alias = '12e8948616587468748674';
			$query->join(DB::raw('`' . $tbl_dic_field_val . '` AS `' . $rand_tbl_alias . '`'), function ($join) use ($rand_tbl_alias, $tbl_dicval, $yesterday3, $yesterday) {
				$join
					->on($rand_tbl_alias . '.dicval_id', '=', $tbl_dicval . '.id')
					->where($rand_tbl_alias . '.key', '=', 'time_limit')
					->where($rand_tbl_alias . '.value', '>=', $yesterday3->format('Y-m-d H:i:s'))
					->where($rand_tbl_alias . '.value', '<', $yesterday->format('Y-m-d H:i:s'))
				;
			});
			$query
				->addSelect(DB::raw('`' . $rand_tbl_alias . '`.`value` AS time_limit'))
			;
		});
		#Helper::smartQueries(1);
		$promises = DicVal::extracts($promises, null, true, true);
        #Helper::tad($promises);

        $this->info('Total full-failed promises: ' . count($promises));

		/**
		 * Если что-то найдено...
		 */
		if (count($promises)) {

			/**
			 * Фильтруем просроченные обещания - оставляем только те, у которых нет явной метки "выполнено" или "провалено"
			 */
			foreach ($promises as $p => $promise) {

				if ($promise->finished_at || $promise->promise_fail)
					unset($promises[$p]);
			}

			$this->info('Filtered promises: ' . count($promises));

            /**
             * Получаем список с IDs обещаний
             */
			#$promises_ids = Dic::makeLists($promises, NULL, 'id');
			#Helper::d($promises_ids);

            /**
             * Группируем обещания по пользователям
             */
            $users_promises = DicLib::groupByField($promises, 'user_id');
            #Helper::tad($users_promises);

			/**
			 * Получаем ID пользователей - авторов обещаний
			 */
			$users_ids = Dic::makeLists($promises, NULL, 'user_id');
			$this->info('Total users: ' . count($users_ids));
            #Helper::d($users_ids);

			$users_ids = array_unique($users_ids);
			$this->info('Filtered (unique) users: ' . count($users_ids));
			#Helper::d($users_ids);
			#Helper::d(implode(', ', $users_ids));
            sort($users_ids);
            $this->info(implode(', ', $users_ids));

			/**
			 * Загружаем пользователей по IDs
			 */
            if (count($users_ids)) {

                $users = Dic::valuesBySlugAndIds('users', $users_ids);
                $users = DicVal::extracts($users, NULL, true, true);
                $this->info('Users objects: ' . count($users));
                foreach ($users as $u => $user) {
                    unset($user->friends);
                    $users[$u] = $user;
                }
                #Helper::ta($users);

                $this->info('Отправляем письма с оповещением о полностью проваленных обещаниях...');

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

                        $data = array(
                            #'promise' => $promise,
                            'user' => $user,
                            'promises' => @$users_promises[$user->id],
                        );


                        /**
                         * Отправка уведомлений на почту...
                         */
                        if (!$only_email || $only_email == $user->email) {

                            #Helper::tad($data);

                            /**
                             * Валидация - установлен ли валидный адрес почты
                             */
                            $validator = Validator::make(array('email' => $user->email), array('email' => 'required|email'));

                            /**
                             * - если прошла валидация почты
                             * - если юзер хочет получать напоминания о сроках своего обещания
                             * - если юзер хочет получать уведомления на почту
                             */
                            if (
                                !$validator->fails()
                                && @$user->notifications['promise_dates']
                                #&& @$user->notifications['on_email']
                            ) {

                                if (!$debug) {

                                    Mail::send('emails.cron_promise_fail', $data, function ($message) use ($user) {
                                        $from_email = Config::get('mail.from.address');
                                        $from_name = Config::get('mail.from.name');
                                        $message->from($from_email, $from_name);
                                        $message->subject('Не удалось выполнить обещание');
                                        $message->to($user->email);
                                    });

                                    /**
                                     * Обновляем время последней отправки уведомлений
                                     */
                                    $user->update_field('last_notification', time());

                                    /**
                                     * Запомним юзера, чтобы не отправлять ему больше, чем одно письмо
                                     */
                                    $also_users[] = $user->id;
                                }

                                $this->info(' + ' . $user->email);
                            }
                        }

                        /**
                         * Отправка уведомления на телефон...
                         */
                        $valid_phone = isset($user->phone_number) && $user->phone_number && preg_match('~^\+\d{11,15}$~is', $user->phone_number);
                        #$this->info('Check phone number ' . $user->phone_number . ' => ' . $valid_phone);
                        #die;

                        /**
                         * - если прошла валидация телефона
                         * - если юзер хочет получать напоминания о сроках своего обещания
                         * - если юзер хочет получать уведомления на телефон
                         */
                        if ($valid_phone && @$user->notifications['promise_dates'] && @$user->notifications['on_phone']) {

                            /*
                             * ОТПРАВКА SMS на $user->phone_number
                             */

                            /**
                             * Обновляем время последней отправки уведомлений
                             */
                            $user->update_field('last_notification', time());
                        }
                    }
                }
            }

		}




		/************************************************************************************************************ */



		$this->info('###################################################################');



		/**
		 * Получаем условно просроченные обещания - у которых срок вышел вчера.
		 * ВЧЕРА - СЕЙЧАС
		 * Такие обещания еще можно отметить как выполненные в течение 48 часов с момента истечения срока выполнения.
		 */
		$promises = Dic::valuesBySlug('promises', function($query) use ($yesterday, $now){

			$tbl_dicval = (new DicVal())->getTable();
			$tbl_dic_field_val = (new DicFieldVal())->getTable();

			$rand_tbl_alias = md5(time() . rand(999999, 9999999));
			$query->join(DB::raw('`' . $tbl_dic_field_val . '` AS `' . $rand_tbl_alias . '`'), function ($join) use ($rand_tbl_alias, $tbl_dicval, $yesterday, $now) {
				$join
					->on($rand_tbl_alias . '.dicval_id', '=', $tbl_dicval . '.id')
					->where($rand_tbl_alias . '.key', '=', 'time_limit')
					->where($rand_tbl_alias . '.value', '>=', $yesterday->format('Y-m-d H:i:s'))
					->where($rand_tbl_alias . '.value', '<', $now->format('Y-m-d H:i:s'))
				;
			});
			$query
				->addSelect(DB::raw('`' . $rand_tbl_alias . '`.`value` AS time_limit'))
			;
		});
		#Helper::smartQueries(1);
		$promises = DicVal::extracts($promises, NULL, true, true);
		#Helper::ta($promises);
		$this->info('Total failed promises: ' . count($promises));

		/**
		 * Если что-то найдено...
		 */
		if (count($promises)) {

			/**
			 * Фильтруем просроченные обещания - оставляем только те, у которых нет метки "выполнено" или "провалено"
			 */
			foreach ($promises as $p => $promise) {

				if ($promise->finished_at || $promise->promise_fail)
					unset($promises[$p]);
			}
			$this->info('Filtered promises: ' . count($promises));

            /**
             * Получаем список с IDs обещаний
             */
            #$promises_ids = Dic::makeLists($promises, NULL, 'id');
            #Helper::d($promises_ids);

            /**
             * Группируем обещания по пользователям
             */
            $users_promises = DicLib::groupByField($promises, 'user_id');
            #Helper::tad($users_promises);

			/**
			 * Получаем ID пользователей - авторов обещаний
			 */
			$users_ids = Dic::makeLists($promises, NULL, 'user_id');
			$this->info('Total users: ' . count($users_ids));
			#Helper::d($users_ids);

			$users_ids = array_unique($users_ids);
			$this->info('Filtered (unique) users: ' . count($users_ids));
			#Helper::d($users_ids);
            #Helper::d(implode(', ', $users_ids));
            sort($users_ids);
            $this->info(implode(', ', $users_ids));

			/**
			 * Загружаем пользователей по IDs
			 */
            if (count($users_ids)) {

                $users = Dic::valuesBySlugAndIds('users', $users_ids);
                $users = DicVal::extracts($users, NULL, true, true);
                $this->info('Users objects: ' . count($users));
                foreach ($users as $u => $user) {
                    unset($user->friends);
                    $users[$u] = $user;
                }
                #Helper::ta($users);

                $this->info('Отправляем письма с оповещением о проваленных обещаниях...');

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

                        $data = array(
                            #'promise' => $promise,
                            'user' => $user,
                            'promises' => @$users_promises[$user->id],
                        );

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
                            if (
                                !$validator->fails()
                                && @$user->notifications['promise_dates']
                                #&& @$user->notifications['on_email']
                            ) {

                                if (!$debug) {

                                    Mail::send('emails.cron_promise_prefail', $data, function ($message) use ($user) {
                                        $from_email = Config::get('mail.from.address');
                                        $from_name = Config::get('mail.from.name');
                                        $message->from($from_email, $from_name);
                                        $message->subject('Еще есть время выполнить свое обещание');
                                        $message->to($user->email);
                                    });

                                    /**
                                     * Обновляем время последней отправки уведомлений
                                     */
                                    $user->update_field('last_notification', time());

                                    /**
                                     * Запомним юзера, чтобы не отправлять ему больше, чем одно письмо
                                     */
                                    $also_users[] = $user->id;
                                }

                                $this->info(' + ' . $user->email);
                            }
                        }

                    }
                }
            }
		}




		/************************************************************************************************************ */



		$this->info('###################################################################');


		/**
		 * Получаем истекающие обещания
		 * ЗАВТРА - ПОСЛЕЗАВТРА
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
					->where($rand_tbl_alias . '.value', '>=', $tomorrow->format('Y-m-d H:i:s'))
					->where($rand_tbl_alias . '.value', '<', $tomorrow2->format('Y-m-d H:i:s'))
				;
			});
			$query
				->addSelect(DB::raw('`' . $rand_tbl_alias . '`.`value` AS time_limit'))
			;
		});
		#Helper::smartQueries(1);
		$promises = DicVal::extracts($promises, NULL, true, true);
		#Helper::ta($promises);
		$this->info('Total expired promises: ' . count($promises));

		/**
		 * Если что-то найдено...
		 */
		if (count($promises)) {

			/**
			 * Фильтруем обещания - оставляем только те, у которых нет метки "выполнено" или "провалено"
			 */
			foreach ($promises as $p => $promise) {

				if ($promise->finished_at || $promise->promise_fail) {
					unset($promises[$p]);
				}
			}
			$this->info('Filtered promises: ' . count($promises));

            /**
             * Получаем список с IDs обещаний
             */
            #$promises_ids = Dic::makeLists($promises, NULL, 'id');
            #Helper::d($promises_ids);

            /**
             * Группируем обещания по пользователям
             */
            $users_promises = DicLib::groupByField($promises, 'user_id');
            #Helper::tad($users_promises);

            /**
			 * Получаем ID пользователей
			 */
			$users_ids = Dic::makeLists($promises, NULL, 'user_id');
			$this->info('Total users: ' . count($users_ids));
			#Helper::d($users_ids);

			$users_ids = array_unique($users_ids);
			$this->info('Filtered (unique) users: ' . count($users_ids));
			#Helper::d($users_ids);
            #Helper::d(implode(', ', $users_ids));
            sort($users_ids);
            $this->info(implode(', ', $users_ids));

			/**
			 * Загружаем пользователей по ID
			 */
            if (count($users_ids)) {
                $users = Dic::valuesBySlugAndIds('users', $users_ids);
                $users = DicVal::extracts($users, NULL, true, true);
                $this->info('Users objects: ' . count($users));
                foreach ($users as $u => $user) {
                    unset($user->friends);
                    $users[$u] = $user;
                }
                #Helper::ta($users);

                $this->info('Отправляем письма с оповещением об истекающих обещаниях...');

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
                        #if (in_array($user->id, $also_users)) {
                        #    continue;
                        #}

                        $user->notifications = json_decode($user->notifications, true);

                        /**
                         * Смотрим на выбранную частоту обновлений и метку отправки последнего уведомления
                         * и решаем, прошел ли выбранный срок или нет.
                         */
                        $subSeconds = @(int)$this->periods[$user->notifications['notify_period']];
                        $period_finish = ($user->last_notification + $subSeconds) < time();
                        if (!$period_finish)
                            continue;

                        $data = array(
                            #'promise' => $promise,
                            'user' => $user,
                            'promises' => @$users_promises[$user->id],
                        );

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
                            if (
                                !$validator->fails()
                                && @$user->notifications['promise_dates']
                                #&& @$user->notifications['on_email']
                            ) {

                                if (!in_array($user->id, $also_users)) {

                                    if (!$debug) {

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

                                        /**
                                         * Запомним юзера, чтобы не отправлять ему больше, чем одно письмо
                                         */
                                        $also_users[] = $user->id;
                                    }

                                    $this->info(' + ' . $user->email);
                                }

                            }
                        }

                        /**
                         * Отправка SMS
                         */
                        $number = $user->phone_number;
                        $number = preg_replace('~[^\d]~is', '', $number);
                        if (strlen($number) < 11 || @!$user->notifications['promise_dates'] || @!$user->notifications['on_phone'])
                            continue;

                        $text = 'Осталось мало времени для выполнения обещания! MyPromises.ru';
                        if (!$debug || $only_sms_number == $number) {
                            SmsAero::sendSms($number, $text);
                        }
                        $this->info('[SMS] + ' . $number);
                    }

                }
            }
		}

        $this->info('###################################################################');
        $this->info('Finish work.');

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
            array('only_sms_number', null, InputOption::VALUE_OPTIONAL, 'Send sms on only this address.', null),
		);
	}

}