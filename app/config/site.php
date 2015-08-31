<?php

return array(

    'theme_path' => 'theme',

    'paginate_limit' => 30,

    ## Disable functionality of changing url "on-the-fly" for generating
    ## seo-friendly url (via URL::route('page', '...')) with right various url-segments for multilingual pages.
    'disable_url_modification' => 0,

    'uploads_dir' => public_path('uploads/files'),

    'uploads_photo_dir' => public_path('uploads'),
    'uploads_thumb_dir' => public_path('uploads/thumbs'),
    'uploads_photo_public_dir' => '/uploads',
    'uploads_thumb_public_dir' => '/uploads/thumbs',

    'galleries_photo_dir' => public_path('uploads/galleries'),
    'galleries_thumb_dir' => public_path('uploads/galleries/thumbs'),
    'galleries_photo_public_dir' => '/uploads/galleries',
    'galleries_thumb_public_dir' => '/uploads/galleries/thumbs',

    'mainpage_promises' => [5815, 5816, 5817, 5818, 5819, 5820, 5821, 5823, 5824, 5825, 5826],
    'mainpage_promises_innova' => [],
    'mainpage_promises_city_aliases' => [
        'мск' => 'Москва',
        'питер' => 'Санкт-Петербург'
    ],

    'twilio' => [
        'sid' => 'AC027e0f38785285c2f456ffd7aaee7b09',
        'token' => '80ec5f6b892fc81f4253fb06a985d424',
    ],

    'notify' => [
        'daily'        => 'Каждый день',
        'weekly_twice' => '2 раза в неделю',
        'weekly'       => '1 раз в неделю',
        'monthly'      => '1 раз в месяц',
    ],
    'notify_periods' => [
        'daily'        => 60*60*24 - 300,
        'weekly_twice' => 60*60*24*3 - 300,
        'weekly'       => 60*60*24*7 - 300,
        'monthly'      => 60*60*24*30 - 300,
    ],

    'sms' => [
        'base'     => 'https://gate.smsaero.ru/',
        'user'     => 'info@grapheme.ru',
        'password' => 'grapheme1234',
        'from'     => 'MyPromises',
    ],

    'achievements' => [
        'new' => [
            'count'     => 1,           ## count of the promises: 1+
            'status'    => 'success',   ## status of the promises: success / fail
            'mode'      => 'total',     ## mode of the logic: total / row
        ],
        'guru' => [
            'count'     => 3,           ## count of the promises: 1+
            'status'    => 'success',   ## status of the promises: success / fail
            'mode'      => 'row',       ## mode of the logic: total / row
        ],
        'sheff' => [
            'count'     => 5,           ## count of the promises: 1+
            'status'    => 'success',   ## status of the promises: success / fail
            'mode'      => 'total',     ## mode of the logic: total / row
        ],
        'man' => [
            'count'     => 10,          ## count of the promises: 1+
            'status'    => 'success',   ## status of the promises: success / fail
            'mode'      => 'total',     ## mode of the logic: total / row
        ],
        'storyteller' => [
            'count'     => 5,
            'status'    => 'fail',
            'mode'      => 'row',
        ],
        'promises_failer' => [
            'count'     => 10,
            'status'    => 'fail',
            'mode'      => 'row',
        ],
    ],

);
