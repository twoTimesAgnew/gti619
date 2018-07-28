<?php

namespace Lib;

use Phalcon\Mvc\Micro as Micro;

class Validator
{
    public static function handle(Micro $app, $id)
    {
        $data = $app->request->getJsonRawBody();

        if(empty($data->number)) {
            $app->response->setStatusCode(400);
            throw new \Exception();
        }

        $otp = self::generateOtp();

        $app->redis->setex($id, 60, hash("sha256", $otp));
        $app->response->setJsonContent($data->number, JSON_UNESCAPED_SLASHES);
        $app->response->setStatusCode(200);
    }
}