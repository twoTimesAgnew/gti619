<?php

include_once BASE_PATH . '/vendor/autoload.php';

/**
 * Registering an autoloader
 */
$loader = new \Phalcon\Loader();

$loader->registerDirs(
    [
        $config->application->modelsDir
    ]
)->register();

$loader->registerNamespaces([
    "Controllers" => APP_PATH . "/controllers",
    "Middleware" => APP_PATH . "/middleware",
    "Lib" => APP_PATH . "/lib",
]);
