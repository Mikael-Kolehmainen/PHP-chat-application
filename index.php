<?php
use public_site\controller\UserController;
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
            <link href='/public_site/styles/css/main.css' rel='stylesheet' type='text/css'>
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
        }
        break;
    case "ajax":
        if (ServerRequestManager::isPost() || ServerRequestManager::isGet()) {
            header('Content-type: Application/json, charset=UTF-8');
            switch ($uri[3]) {

                case null: default:
                    header("HTTP/1.1 404 Not Found");
                    exit();
            }
        }
        break;
    default:
        header("HTTP/1.1 404 Not Found");
        exit();
}

if ($uri[2] != "ajax") {
    echo "
            </body>
        </html>
    ";
}

function showCreateUserForm()
{
    $userController = new UserController();
    $userController->showCreateForm();
}

function showLogInUserForm()
{
    $userController = new UserController();
    $userController->showLogInForm();
}