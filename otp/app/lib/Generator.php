<?php

namespace Lib;

use Phalcon\Mvc\Micro as Micro;

class Generator
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
        $fields = [
            "number" => urlencode($data->number),
            "message" => urlencode($otp)
        ];
        $fields_string = "";
        //url-ify the data for the POST
        foreach($fields as $key=>$value)
        {
            $fields_string .= $key.'='.$value.'&';
        }
        rtrim($fields_string, '&');

        $ch = curl_init("textbelt:9090/text");
        curl_setopt($ch, CURLOPT_POST, count($fields));
        curl_setopt($ch, CURLOPT_POSTFIELDS, $fields_string);
        $res = curl_exec($ch);
        curl_close($ch);
        $result = json_decode($res,true);
        var_dump($result);
        die();
        $app->response->setStatusCode(200);
    }

    private static function generateOtp()
    {
        $otp = null;
        $unmixed = rand(100000, 999999);
        $unmixed .= rand(100000, 999999);
        $mixed = str_shuffle($unmixed);
        $otp = substr($mixed, rand(0, 3), 6);

        return $otp;
    }
}