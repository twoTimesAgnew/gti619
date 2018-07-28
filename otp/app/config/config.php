<?php

defined('BASE_PATH') || define('BASE_PATH', getenv('BASE_PATH') ?: realpath(dirname(__FILE__) . '/../..'));
defined('APP_PATH') || define('APP_PATH', BASE_PATH . '/app');

return new \Phalcon\Config([
    'application' => [
        'modelsDir'      => APP_PATH . '/models/',
        'migrationsDir'  => APP_PATH . '/migrations/',
        'viewsDir'       => APP_PATH . '/views/',
        'baseUri'        => '/otp/',
    ],

    'redis' => [
        'host' => "redis",
        'port' => 6379,
        'db' => 0,
        'retryInterval' => 100,
        'timeout' => 1
    ],

    "logs" => [
        "api" => APP_PATH . "/logs/api.txt",
        "error" => APP_PATH . "/logs/error.txt"
    ]
]);
