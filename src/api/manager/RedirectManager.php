<?php

namespace api\manager;

class RedirectManager
{
    public static function redirectToGroups(): void
    {
        header("Location: /index.php/groups");
    }

    public static function redirectToChat($groupId): void
    {
        header("Location: /index.php/group/chat/$groupId");
    }

    public static function redirectToLogIn(): void
    {
        header("Location: /index.php/user/log-in");
    }
}