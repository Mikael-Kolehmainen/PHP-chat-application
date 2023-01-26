<?php

namespace public_site\controller;

use api\manager\ServerRequestManager;
use api\manager\SessionManager;
use api\manager\RedirectManager;
use api\model\UserModel;
use api\model\GroupModel;
use api\model\FileModel;
use api\model\Database;
use api\misc\RandomString;

class UserController
{
    /** @var int */
    public $id;

    /** @var string */
    private $identifier;

    /** @var string */
    private $imagePath;

    /** @var Database */
    private $db;

    /** @var int */
    public $groupsId;

    public function __construct()
    {
        $this->db = new Database();
    }

    /**
     *  /index.php/user/select
     */
    public function logInUser(): void
    {
        if ($this->checkCredentials()) {
            $this->saveIdentifierToSession();
            RedirectManager::redirectToGroups();
        } else {
            $this->showLogInError();
        }
    }

    private function checkCredentials(): bool
    {
        $userModel = new UserModel($this->db);
        $userModel->username = ServerRequestManager::postUsername();

        $user = $userModel->loadWithUsername();
        $this->identifier = $user->identifier;

        $userPassword = $user->password;
        $inputtedPassword = ServerRequestManager::postPassword();

        return password_verify($inputtedPassword, $userPassword);
    }

    private function showLogInError(): void
    {
        $errorController = new ErrorController("Credentials are incorrect", "The credentials are incorrect, please try again.", "/index.php/user/log-in");
        $errorController->showErrorPage();
    }

    /**
     *  /index.php/user/insert
     */
    public function saveUser(): void
    {
        if ($this->uniqueUsername()) {
            $this->saveUserImageToServer();
            $this->insertUserToDatabase();
            $this->saveIdentifierToSession();
            RedirectManager::redirectToGroups();
        } else {
            $this->showCreationError();
        }
    }

    private function uniqueUsername(): bool
    {
        $userModel = new UserModel($this->db);
        $userModel->username = ServerRequestManager::postUsername();

        return empty($userModel->loadWithUsername()->username);
    }

    private function saveUserImageToServer(): void
    {
        $fileModel = new FileModel(ServerRequestManager::filesUserImage(), "/src/public_site/media/users/$fileName");
        $fileModel->generateFileName();
        $this->imagePath = $fileModel->createFilePath();
        $fileModel->saveFileToServer();
    }

    private function insertUserToDatabase(): void
    {
        $userModel = new UserModel($this->db);
        $userModel->username = ServerRequestManager::postUsername();
        $userModel->image = $this->imagePath;
        $userModel->password = password_hash(ServerRequestManager::postPassword(), PASSWORD_DEFAULT);
        $userModel->identifier = RandomString::getRandomString(20);

        $this->identifier = $userModel->identifier;
        $this->id = $userModel->save();
    }

    private function saveIdentifierToSession(): void
    {
        SessionManager::saveUserIdentifier($this->identifier);
    }

    private function showCreationError(): void
    {
        $errorController = new ErrorController("Username exists", "The given username already exists, please try with another one.", "/index.php/user/create");
        $errorController->showErrorPage();
    }

    public function logOut(): void
    {
        SessionManager::deleteUserIdentifier();
        RedirectManager::redirectToLogIn();
    }

    /**
     * @return GroupModel[]
     */
    public function getMyGroups()
    {
        $groupIds = $this->getGroupIds();

        $groups = [];
        $i = 0;
        foreach ($groupIds as $id) {
            $groupModel = new GroupModel($this->db);
            $groupModel->id = $id;
            $groups[$i] = $groupModel->load();

            $i++;
        }

        return $groups;
    }

    private function getGroupIds()
    {
        $userModel = new UserModel($this->db);
        $userModel->id = $this->id;
        return $userModel->loadGroupsIds();
    }

    public function addToGroup()
    {
        $userModel = new UserModel($this->db);
        $userModel->id = $this->id;
        $userModel->groupsId = $this->groupsId;
        $userModel->saveUsersToGroup();
    }

    public function getId()
    {
        $userModel = new UserModel($this->db);
        $userModel->identifier = SessionManager::getUserIdentifier();

        return $userModel->loadWithIdentifier()->id;
    }

    /**
     *  /index.php/group/insert-user/{group.id}
     */
    public function addUsersToGroup()
    {
        $this->insertUsersToGroup();
        RedirectManager::redirectToChat($this->groupsId);
    }

    private function insertUsersToGroup()
    {
        $this->groupsId = ServerRequestManager::getGroupIdFromUri();

        // checkbox name is 'username-checkbox-{userid}'
        foreach ($_POST as $name => $value) {
            $name = explode("-", $name);
            if ($name[0] == "username"
                && $name[1] == "checkbox") {
                $this->id = $name[2];
                $this->addToGroup();
            }

        }
    }

    public function getImagePath()
    {
        $userModel = new UserModel($this->db);
        $userModel->id = $this->id;

        return $userModel->load()->image;
    }

    /**
     *  /index.php/user/create
     */
    public function showCreateForm(): void
    {
        echo "
            <title>Chat-app | Create User</title>
            <script src='/src/public_site/js/file-functions.js' defer></script>
            <script src='/src/public_site/js/password-validation.js' defer></script>
        </head>
        <section>
            <article class='box create-user'>
                <h1>WELCOME</h1>
                <form action='/index.php/user/insert' method='POST' enctype='multipart/form-data'>
                    <label class='circle-file-input' id='image-file-input'>
                        <input type='file' id='image' name='user-image' accept='png/jpg/jpeg/gif' required>
                        <p id='file-input-text'>CHOOSE IMAGE</p>
                    </label>
                    <input type='text' name='username' class='input-field' maxlength='20' onkeydown='return /[a-z0-9]/i.test(event.key)' placeholder='USERNAME' required>
                    <input type='password' id='pw1' class='input-field' maxlength='25' onkeydown='return /[a-z0-9]/i.test(event.key)' placeholder='PASSWORD' required>
                    <input type='password' id='pw2' name='pw' class='input-field' maxlength='25' onkeydown='return /[a-z0-9]/i.test(event.key)' placeholder='REPEAT PASSWORD' required>
                    <p id='validation-msg'> </p>
                    <div class='small-notice'>
                        <p>Password must be at least:</p>
                        <ul>
                            <li id='pw-length-validation'>8 characters long</li>
                        </ul>
                    </div>
                    <input type='submit' id='create-btn' name='create-user' class='btn' value='CREATE' disabled>
                </form>
                <a href='/index.php/user/log-in'>Already a user? Click here</a>
            </article>
        </section>
        ";
    }

    /**
     *  /index.php/user/log-in
     */
    public function showLogInForm(): void
    {
        echo "
            <title>Chat-app | Login</title>
        </head>
        <section>
            <article class='box login'>
                <h1>WELCOME BACK!</h1>
                <form action='/index.php/user/select' method='POST'>
                    <input type='text' name='username' class='input-field' maxlength='25' onkeydown='return /[a-z0-9]/i.test(event.key)' placeholder='USERNAME' required>
                    <input type='password' name='pw' class='input-field' maxlength='25' onkeydown='return /[a-z0-9]/i.test(event.key)' placeholder='PASSWORD' required>
                    <input type='submit' name='log-in' class='btn' value='LOGIN'>
                </form>
                <a href='/index.php/user/create'>New? Click here</a>
            </article>
        </section>
        ";
    }
}