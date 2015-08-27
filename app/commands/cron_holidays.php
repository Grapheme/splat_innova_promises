<?php

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

class CronHolidays extends Command {

	/**
	 * The console command name.
	 *
	 * @var string
	 */
	protected $name = 'cron:holidays';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'Напоминания на праздники';

	/**
	 * Create a new command instance.
	 */
	public function __construct() {
		parent::__construct();
		date_default_timezone_set("Europe/Moscow");
        $this->reasons = [

            '01.01' => [
                'title' => 'С Новым Годом!',
                'text'  => 'С Новым Годом, %name%! Пусть в наступившем году вас окружает тепло, любовь и забота, а все ваши обещания непременно становятся делами и преображают мир вокруг. Самое время наметить новые планы и дать себе новые обещания на сайте mypromises.ru!',
            ], # 1 января

            '14.02' => [
                'title' => 'С Днём всех влюблённых!',
                'text'  => 'В день всех влюблённых мы хотим пожелать вам ещё больше любви и понимания, а если рядом всё ещё нет подходящего человека — непременно его встретить! Наверняка и вам есть что пообещать в этот знаменательный день себе или своей половинке: mypromises.ru',
            ], # 14 февраля

            '09.05' => [
                'title' => 'Важная дата',
                'text'  => 'Уже завтра вся Россия будет отмечать годовщину Великой Победы, а по нашим улицам вновь пройдут праздничные парады. Сегодня — лучший день, чтобы пообещать себе сделать доброе дело 9 мая или порадовать ветеранов. Оставьте своё обещание на сайте mypromises.ru',
            ], # 9 мая

            '01.12' => [
                'title' => 'Время действовать',
                'text'  => 'Через 30 дней наступит Новый Год. С ним придут новые надежды, мечты и планы, а значит, сейчас — отличное время, чтобы закончить намеченное в уходящем году. Просто оставьте свое обещание на сайте mypromises.ru, а мы обязательно поможем вам его выполнить.',
            ], # 1 декабря

            'birthday' => [
                'title' => 'С Днём Рождения!',
                'text'  => 'В этот поистине особенный день мы хотим от всей души пожелать вам здоровья, долголетия, гармонии внутри вас, и конечно же достижения даже самых смелых целей. А чтобы они ещё быстрее стали реальностью, оставьте своё обещание на mypromises.ru — и мы обязательно поможем вам выполнить их! С днём рождения!',
            ], # день рождения юзера
        ];
	}

	/**
	 * Execute the console command.
	 *
	 * @return mixed
	 */
	public function fire() {

        $reason = $this->option('reason');
        if (!isset($this->reasons[$reason])) {
            $this->error('BAD REASON: ' . $reason);
            $this->info('Available reasons: ' . implode(', ', array_keys($this->reasons)));
            return;
        }

        $debug = $this->argument('debug') ?: false;

        $this->info('START TO SEND NOTIFICATIONS OF HOLIDAYS');

        if ($debug)
			$this->info('RUN IN DEBUG MODE - MAILs WILL NOT BE SEND');

		$this->info('System time: ' . date('Y-m-d H:i:s'));

		#die;

		/************************************************************************************************************ */


        /**
         * Получаем все имеющиеся e-mail адреса
         * SELECT DISTINCT `value` FROM `dictionary_fields_values` WHERE `key` = 'email' AND `value` LIKE('%@%')
         */
        /*
        $emails = (new DicFieldVal())->where('key', 'email')->where('value', 'LIKE', '%@%')->select('value')->distinct()->get();
        if (!count($emails)) {
            $this->info('Email not found in DB, exit.');
            return;
        }

        $emails = $emails->lists('value');
        #Helper::tad($emails);
        #die;

        $this->info('Total emails: ' . count($emails) . ', start to sending messages...');

        foreach ($emails as $email) {

        }
        */

        /**
         * Получаем юзеров, у которых указан валидный e-mail
         */
        $users = Dic::valuesBySlug('users', function($query) {
            $query->filter_by_field('email', 'LIKE', '%@%');
        });
        if (is_object($users) && $users->count()) {
            foreach ($users as $u => $user) {
                $user = $user->extract(1);
                unset($user->full_social_info);
                unset($user->friends);

                if ($reason == 'birthday' && $user->bdate != date('d.m.Y'))
                    continue;


                $users[$u] = $user;
            }
        }
        Helper::tad($users);




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
             * Группируем обещания по пользователям
             */
            $users_promises = DicLib::groupByField($promises, 'user_id');
            #Helper::tad($users_promises);

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
                            'promises' => @$users_promises[$user->id],
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
                                if (
                                    !$validator->fails()
                                    && @$user->notifications['promise_dates']
                                    #&& @$user->notifications['on_email']
                                ) {

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
			array('reason', null, InputOption::VALUE_REQUIRED, 'Reason for email sending.', null),
		);
	}

}

