<?php

use Phalcon\Mvc\View\Simple as View;
use Phalcon\Mvc\Url as UrlResolver;
use Phalcon\Logger\Adapter\File as Logger;

/**
 * Shared configuration service
 */
$di->setShared('config', function () {
    return include APP_PATH . "/config/config.php";
});

/**
 * Sets the view component
 */
$di->setShared('view', function () {
    $config = $this->getConfig();

    $view = new View();
    $view->setViewsDir($config->application->viewsDir);
    return $view;
});

/**
 * The URL component is used to generate all kind of urls in the application
 */
$di->setShared('url', function () {
    $config = $this->getConfig();

    $url = new UrlResolver();
    $url->setBaseUri($config->application->baseUri);
    return $url;
});

$di->setShared('redis', function () {
    $config = $this->getConfig();

    $redis = new Redis();
    $redis->connect($config['redis']['host'], $config['redis']['port'],
                    $config['redis']['timeout'], NULL, $config['redis']['retryInterval']);
    $redis->select(0);

    return $redis;
});

/** * Sets shared loggers */
$di->setShared('apiLogger', function () {
    $config = $this->getConfig();
    $logger = new Logger($config->logs->api);
    return $logger;
});

$di->setShared('errorLogger', function () {
    $config = $this->getConfig();
    $logger = new Logger($config->logs->error);
    return $logger;
});

