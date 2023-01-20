<?php

namespace api\manager;

class SessionManager
{
    private const USER_IDENTIFIER = "user-identifier";

    public static function saveUserIdentifier($identifier): void
    {
        $_SESSION[self::USER_IDENTIFIER] = $identifier;
    }

    public static function issetUserIdentifier(): bool
    {
        return isset($_SESSION[self::USER_IDENTIFIER]);
    }

    public static function getUserIdentifier(): string
    {
        return $_SESSION[self::USER_IDENTIFIER];
    }

    public static function deleteUserIdentifier(): void
    {
        unset($_SESSION[self::USER_IDENTIFIER]);
    }
}