<?php

namespace api\manager;

class RedirectManager
{
    public static function redirectToGroups(): void
    {
        echo "<script>window.location.href = '/index.php/groups';</script>";
    }

    public static function redirectToChat($groupId): void
    {
        echo "<script>window.location.href = '/index.php/group/chat/$groupId';</script>";
    }

    public static function redirectToLogIn(): void
    {
        echo "<script>window.location.href = '/index.php/user/log-in';</script>";
    }
}