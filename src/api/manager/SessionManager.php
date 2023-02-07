<?php

namespace api\manager;

class SessionManager
{
    private const USER_IDENTIFIER = "user-identifier";
    private const AMOUNT_OF_MESSAGES = "amount-of-messages";

    public static function issetUserIdentifier(): bool
    {
        return isset($_SESSION[self::USER_IDENTIFIER]);
    }

    public static function saveUserIdentifier($identifier): void
    {
        $_SESSION[self::USER_IDENTIFIER] = $identifier;
    }

    public static function getUserIdentifier(): string
    {
        return $_SESSION[self::USER_IDENTIFIER];
    }

    public static function deleteUserIdentifier(): void
    {
        unset($_SESSION[self::USER_IDENTIFIER]);
    }

    public static function issetAmountOfMessages(): bool
    {
        return isset($_SESSION[self::AMOUNT_OF_MESSAGES]);
    }

    public static function saveAmountOfMessages($amountOfMessages): void
    {
        $_SESSION[self::AMOUNT_OF_MESSAGES] = $amountOfMessages;
    }

    public static function getAmountOfMessages(): int
    {
        return $_SESSION[self::AMOUNT_OF_MESSAGES];
    }

    public static function deleteAmountOfMessages(): void
    {
        unset($_SESSION[self::AMOUNT_OF_MESSAGES]);
    }
}