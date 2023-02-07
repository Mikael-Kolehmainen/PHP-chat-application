<?php

namespace api\manager;

use api\model\GroupModel;
use public_site\controller\ErrorController;
use public_site\controller\GroupController;

class ValidationManager
{
    public static function validaterUserLoggedIn(): void
    {
        if (!SessionManager::issetUserIdentifier()) {
            $errorController = new ErrorController("Not logged in", "You're not logged in, please login or create an account.", "/index.php/user/create");
            $errorController->showErrorPage();
            exit();
        }
    }

    public static function validateGroupExistence($db, $groupId): void
    {
        $groupModel = new GroupModel($db);
        $groupModel->id = $groupId;

        if (empty($groupModel->load()->id)) {
            $errorController = new ErrorController("Group doesn't exist", "The group couldn't be found with the given id.", "/index.php/groups");
            $errorController->showErrorPage();
            exit();
        }
    }

    public static function validateUserGroupMembership(): void
    {
        $groupController = new GroupController();

        if (!$groupController->userIsAMember()) {
            $errorController = new ErrorController("You're not a part of the group", "You're not a part of the given group.", "/index.php/groups");
            $errorController->showErrorPage();
            exit();
        }
    }
}