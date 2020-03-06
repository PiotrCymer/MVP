<?php


namespace appEngine\Core\helpers;


class Token
{
    private static $newToken;

    private static $encrypt_method = "AES-256-CBC";

    private static $iv = 'rfhsjakfbcgdtery';

    private static $privateApiKey = "zaCELgL.0imfnc8mVLWwsAawjYr4Rx-Af50DDqtlx";


    public static function generate($string)
    {
        $tokenString = $string.self::$privateApiKey;
        self::$newToken = openssl_encrypt($tokenString, self::$encrypt_method, self::$privateApiKey, 0, self::$iv);

        return self::$newToken;
    }

    public static function validateToken($tokenToCheck)
    {
        $output = openssl_decrypt($tokenToCheck, self::$encrypt_method,self::$privateApiKey , 0, self::$iv);

        if($output) {
            return true;
        }
        return false;
    }

    public static function getToken()
    {
        return self::$newToken;
    }


}