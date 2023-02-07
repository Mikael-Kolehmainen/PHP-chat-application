<?php

namespace api\manager;

class ServerRequestManager
{
    private const REQUEST_METHOD = "REQUEST_METHOD";
    private const POST = "POST";
    private const GET = "GET";
    private const REQUEST_URI = "REQUEST_URI";
    private const CREATE_USER = "create-user";
    private const LOG_IN = "log-in";
    private const SEND_MESSAGE = "send-message";
    private const MESSAGE = "message";
    private const USERNAME = "username";
    private const USER_IMAGE = "user-image";
    private const PASSWORD = "pw";
    private const CREATE_GROUP = "create-group";
    private const GROUP_NAME = "group-name";
    private const GROUP_IMAGE = "group-image";
    private const GROUP_ID = "group-id";
    private const GROUP_ADD_USER = "group-add-user";
    private const MESSAGE_IMAGE = "webimagepath";
    private const MESSAGE_IMAGE_EXT = "webimagetype";

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

    public static function getGroupIdFromUri(): string|null
    {
        return self::getUriParts()[4];
    }

    public static function issetCreateUser(): bool
    {
        return isset($_POST[self::CREATE_USER]);
    }

    public static function issetLogIn(): bool
    {
        return isset($_POST[self::LOG_IN]);
    }

    public static function issetCreateGroup(): bool
    {
        return isset($_POST[self::CREATE_GROUP]);
    }

    public static function issetGroupAddUser(): bool
    {
        return isset($_POST[self::GROUP_ADD_USER]);
    }

    public static function issetSendMessage(): bool
    {
        return isset($_POST[self::SEND_MESSAGE]);
    }

    public static function postMessage(): string
    {
        return $_POST[self::MESSAGE];
    }

    public static function postUsername(): string
    {
        return $_POST[self::USERNAME];
    }

    public static function postPassword(): string
    {
        return $_POST[self::PASSWORD];
    }

    public static function postGroupName(): string
    {
        return $_POST[self::GROUP_NAME];
    }

    public static function postMessageExt(): string
    {
        return $_POST[self::MESSAGE_IMAGE_EXT];
    }

    public static function postMessageGroupId(): int
    {
        return $_POST[self::GROUP_ID];
    }

    public static function filesUserImage(): array
    {
        return $_FILES[self::USER_IMAGE];
    }

    public static function filesGroupImage(): array
    {
        return $_FILES[self::GROUP_IMAGE];
    }

    public static function filesMessageImage(): array
    {
        return $_FILES[self::MESSAGE_IMAGE];
    }
}