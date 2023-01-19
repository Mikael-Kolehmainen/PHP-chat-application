<?php

namespace api\manager;

class ServerRequestManager
{
    private const REQUEST_METHOD = "REQUEST_METHOD";
    private const POST = "POST";
    private const GET = "GET";
    private const REQUEST_URI = "REQUEST_URI";
    private const USERNAME = "username";
    private const USER_IMAGE = "user-image";
    private const PASSWORD = "pw";

    public static function isPost(): bool
    {
        return $_SERVER[self::REQUEST_METHOD] == self::POST;
    }

    public static function isGet(): bool
    {
        return $_SERVER[self::REQUEST_METHOD] == self::GET;
    }

    /**
     * @return array<string>|bool
     */
    public static function getUriParts()
    {
        $uri = parse_url($_SERVER[self::REQUEST_URI], PHP_URL_PATH);
        return explode('/', $uri);
    }

    public static function issetCreateUser(): bool
    {
        return isset($_POST[self::USERNAME]);
    }

    public static function postUsername(): string
    {
        return $_POST[self::USERNAME];
    }

    public static function filesUserImage(): array
    {
        return $_FILES[self::USER_IMAGE];
    }

    public static function postPassword(): string
    {
        return $_POST[self::PASSWORD];
    }
}