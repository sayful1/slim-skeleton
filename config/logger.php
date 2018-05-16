<?php
return [
    'logger' => [
        'name'  => 'slim-app',
        'path'  => dirname(__DIR__) . '/storage/logs/slim-' . date('Y-m-d', time()) . '.log',
        'level' => \Monolog\Logger::DEBUG,
    ]
];