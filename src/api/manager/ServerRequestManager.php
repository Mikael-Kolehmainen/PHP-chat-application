<?php

namespace api\manager;

class ServerRequestManager
{
    private const REQUEST_METHOD = "REQUEST_METHOD";
    private const POST = "POST";
    private const GET = "GET";
    private const REQUEST_URI = "REQUEST_URI";
    private const USERNAME = "username";

    public static function isPost()
    {
        return $_SERVER[self::REQUEST_METHOD] == self::POST;
    }

    public static function isGet()
    {
        return $_SERVER[self::REQUEST_METHOD] == self::GET;
    }

    public static function getUriParts()
    {
        $uri = parse_url($_SERVER[self::REQUEST_URI], PHP_URL_PATH);
        return explode('/', $uri);
    }

    public static function issetCreateUser()
    {
        return isset($_POST[self::USERNAME]);
    }
}