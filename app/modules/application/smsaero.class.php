<?php

class SmsAero {

    /**
     * Отправка SMS-сообщения
     *
     * @param $number
     * @param $text
     *
     * @return mixed
     */
    public static function sendSms($number, $text) {

        #$number = '79044442177';
        #$text = 'Тест отправки SMS сообщения';

        /**
         * Отправка сообщения на указанный номер
         */
        $url = Config::get('site.sms.base') . 'send/?&answer=json&user=' . Config::get('site.sms.user') . '&password=' . md5(Config::get('site.sms.password')) . '&from=' . Config::get('site.sms.from') . '&to=' . $number . '&text=' . urlencode($text);

        /**
         * Баланс
         */
        #$url = 'https://gate.smsaero.ru/balance/?answer=json&user=' . Config::get('site.sms.user') . '&password=' . md5(Config::get('site.sms.password'));

        #Helper::d($url);

        /**
         * Отправка запроса
         */
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($ch);
        curl_close($ch);

        #Helper::d($response);
        #die;

        return $response;
    }
}