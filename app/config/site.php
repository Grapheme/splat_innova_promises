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

    'mainpage_promises' => [3273, 3255, 3205, 2855, 3904, 3655, 3644, 3284, 3480, 4025, 3956],
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
    ]

);
