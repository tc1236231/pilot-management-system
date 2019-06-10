<?php

return [
    // HTTP 请求的超时时间（秒）
    'timeout' => 5.0,

    // 默认发送配置
    'default' => [
        // 网关调用策略，默认：顺序调用
        'strategy' => \Overtrue\EasySms\Strategies\OrderStrategy::class,

        // 默认可用的发送网关
        'gateways' => [
            'aliyun',
        ],
    ],
    // 可用的网关配置
    'gateways' => [
        'errorlog' => [
            'file' => '/tmp/easy-sms.log',
        ],
        'yunpian' => [
            'api_key' => '824f0ff2f71cab52936axxxxxxxxxx',
        ],
        'aliyun' => [
            'access_key_id' => env('ALIYUN_SMS_APP_ID', 'xxxxxxx'),
            'access_key_secret' => env('ALIYUN_SMS_APP_SECRET', 'xxxxxxx'),
            'sign_name' => env('ALIYUN_SMS_APP_SIGN_NAME', 'xxxxxxx'),
        ],
        'juhe' => [
            'app_key' => env('JUHE_SMS_APP_KEY', 'xxxxxxx'),
        ],
        //...
    ],
];