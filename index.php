<?php

use public_site\controller\GroupController;
use public_site\controller\MessageController;
use public_site\controller\CameraController;
use public_site\controller\UserController;
use public_site\controller\ErrorController;
use api\manager\ServerRequestManager;

require __DIR__ . "/src/inc/bootstrap.php";

session_start();

$uri = ServerRequestManager::getUriParts();

if (!isset($uri[2])) {
    $uri[2] = "user";
    $uri[3] = "create";
}

if ($uri[2] != "ajax") {
    echo "
    <!DOCTYPE html>
    <html>
        <head>
            <meta name='viewport' content='width=device-width, initial-scale=1'>
            <link rel='icon' type='image/x-icon' href='/src/public_site/media/icons/favicon.svg'>
            <link href='/src/public_site/styles/css/main.css' rel='stylesheet' type='text/css'>
    ";
}

switch ($uri[2]) {
    case "user":
        switch ($uri[3]) {
            case "create":
                showCreateUserForm();
                break;
            case "log-in":
                showLogInUserForm();
                break;
            case "log-out":
                logOutUser();
                break;
            case "insert":
                if (ServerRequestManager::issetCreateUser()) {
                    saveUserDetails();
                } else {
                    showError(
                        "Error in user creation",
                        "Please fill the form on the create user page.",
                        "/index.php/user/create"
                    );
                }
                break;
            case "select":
                if (ServerRequestManager::issetLogIn()) {
                    logInUser();
                } else {
                    showError(
                        "Error in user login",
                        "Please fill the form on the login page.",
                        "/index.php/user/log-in"
                    );
                }
                break;
        }
        break;
    case "groups":
        showGroups();
        break;
    case "group":
        switch ($uri[3]) {
            case "create":
                showCreateGroupForm();
                break;
            case "chat":
                showGroupChat();
                break;
            case "camera":
                showCamera();
                break;
            case "add-user":
                showAddUsersForm();
                break;
            case "insert-user":
                if (ServerRequestManager::issetGroupAddUser()) {
                    saveUsersAsGroupMember();
                } else {
                    showError(
                        "Error in adding users to group",
                        "Please fill the form on the add users to group page",
                        "/index.php/groups"
                    );
                }
                break;
            case "insert":
                if (ServerRequestManager::issetCreateGroup()) {
                    saveGroupDetails();
                } else {
                    showError(
                        "Error in group creation",
                        "Please fill the form on the group creation page.",
                        "/index.php/group/create"
                    );
                }
                break;
        }
        break;
    case "message":
        if (ServerRequestManager::issetSendMessage()) {
            sendMessageToGroup();
        } else {
            showError(
                "Error in sending message",
                "Please send a message in a chat.",
                "/index.php/groups"
            );
        }
        break;
    case "ajax":
        if (ServerRequestManager::isPost() || ServerRequestManager::isGet()) {
            header('Content-type: Application/json, charset=UTF-8');
            switch ($uri[3]) {
                case "get-messages":
                    getMessages();
                    break;
                case "send-media":
                    sendMedia();
                    break;
                case "remove-messages-session":
                    removeMessagesSession();
                    break;
                case null: default:
                    header("HTTP/1.1 404 Not Found");
                    exit();
            }
        }
        break;
    default:
        showError(
            "404 Not Found",
            "The page you're looking for doesn't exist.",
            "/index.php/user/create"
        );
        exit();
}

if ($uri[2] != "ajax") {
    echo "
            </body>
        </html>
    ";
}

function showCreateUserForm(): void
{
    $userController = new UserController();
    $userController->showCreateForm();
}

function showLogInUserForm(): void
{
    $userController = new UserController();
    $userController->showLogInForm();
}

function logOutUser(): void
{
    $userController = new UserController();
    $userController->logOut();
}

function saveUserDetails(): void
{
    $userController = new UserController();
    $userController->saveUser();
}

function logInUser(): void
{
    $userController = new UserController();
    $userController->logInUser();
}

function showGroups(): void
{
    $groupController = new GroupController();
    $groupController->showGroups();
}

function showCreateGroupForm(): void
{
    $groupController = new GroupController();
    $groupController->showCreateGroup();
}

function showGroupChat(): void
{
    $groupController = new GroupController();
    $groupController->showChat();
}

function showCamera(): void
{
    $cameraController = new CameraController();
    $cameraController->showCamera();
}

function showAddUsersForm(): void
{
    $groupController = new GroupController();
    $groupController->showAddUsers();
}

function saveUsersAsGroupMember(): void
{
    $userController = new UserController();
    $userController->addUsersToGroup();
}

function saveGroupDetails(): void
{
    $groupController = new GroupController();
    $groupController->saveGroup();
}

function sendMessageToGroup(): void
{
    $messageController = new MessageController();
    $messageController->sendMessage();
}

function getMessages(): void
{
    $messageController = new MessageController();
    $messageController->encodeDataToJSON();
}

function sendMedia(): void
{
    $messageController = new MessageController();
    $messageController->sendMedia();
}

function removeMessagesSession(): void
{
    $messageController = new MessageController();
    $messageController->removeSession();
}

function showError($title, $message, $link): void
{
    $errorController = new ErrorController($title, $message, $link);
    $errorController->showErrorPage();
}