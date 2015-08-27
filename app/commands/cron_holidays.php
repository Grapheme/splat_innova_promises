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
        $users = Dic::valuesBySlug('users', function($query) use ($reason) {

            $query->filter_by_field('email', 'LIKE', '%@%');

            /**
             * Хук для режима рассылки birthday
             */
            if ($reason == 'birthday') {

                $query->filter_by_field('bdate', '=', date('d.m.Y'));
                #$query->filter_by_field('bdate', '=', '29.05.1987');
            }
        });
        if (is_object($users) && $users->count()) {
            $temp = new Collection();
            foreach ($users as $u => $user) {
                $user = $user->extract(1);
                unset($user->full_social_info);
                unset($user->friends);

                $temp[] = $user;
            }
            $users = $temp;
        }
        #Helper::ta($users);
        $this->info('Total users: ' . count($users) . '');

        if (!count($users))
            return;

        if ($debug) {
            $this->info('Debug mode, exit.');
            return;
        }

        $this->info('Start to sending messages...');
        #die;

        $data = [
            'title' => $this->reasons[$reason]['title'],
        ];

        $also_sended = [];
        $i = 0;

        foreach ($users as $user) {


            ## DEBUG
            #if ($user->email != 'reserved@mail.ru')
            #    continue;


            /**
             * Один email - одно письмо
             */
            if (@$also_sended[$user->email])
                continue;

            $data['user'] = $user;
            $data['text'] = strtr($this->reasons[$reason]['text'], [
                '%name%' => $user->name,
                'mypromises.ru' => '<a href="http://mypromises.ru">mypromises.ru</a>',
            ]);

            /**
             * Валидация - установлен ли валидный адрес почты
             */
            $validator = Validator::make(array('email' => $user->email), array('email' => 'required|email'));

            /**
             * - если прошла валидация почты
             * - если юзер хочет получать уведомления на почту
             */
            if (
                !$validator->fails()
                #&& @$user->notifications['on_email']
            ) {

                Mail::send('emails.cron_holidays', $data, function ($message) use ($user, $data) {
                    $from_email = Config::get('mail.from.address');
                    $from_name = Config::get('mail.from.name');
                    $message->from($from_email, $from_name);
                    $message->subject($data['title']);
                    $message->to($user->email);
                });

                $this->info(' + ' . $user->email);
                ++$i;
                $also_sended[$user->email] = 1;
            }
        }

        $this->info('Finish work, total sended messages: ' . $i);
        #die;
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

