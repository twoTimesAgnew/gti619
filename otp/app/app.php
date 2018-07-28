<?php

use Lib\Generator;

/**
 * Local variables
 * @var \Phalcon\Mvc\Micro $app
 */

/**
 * Add your routes here
 */
$app->map('/', function () use ($app) {
    $app->response->setStatusCode(200);
    $app->response->setJsonContent("Almost there!", JSON_UNESCAPED_SLASHES);
    $app->response->send();
});

$app->post('/otp/generate/{id}', function ($id) use ($app) {
    try
    {
        Generator::handle($app, $id);
    } catch (Exception $e) {
        $app->errorLogger->error($e->getMessage());
    }

    $app->response->send();
});

$app->post('/otp/validate/{id}', function ($id) use ($app) {
    try
    {
        Validator::handle($app, $id);
    } catch (Exception $e) {
        $app->errorLogger->error($e->getMessage());
    }

    $app->response->send();
});

/**
 * Not found handler
 */
$app->notFound(function () use($app) {
    $app->response->setStatusCode(404);
    $app->response->send();
});
