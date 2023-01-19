<?php

namespace public_site\controller;

use api\manager\ServerRequestManager;
use api\manager\SessionManager;
use api\model\UserModel;
use api\model\FileModel;
use api\model\Database;
use api\misc\RandomString;

class UserController
{
    /** @var int */
    private $id;

    /** @var string */
    private $identifier;

    /** @var Database */
    private $db;

    /** @var string */
    private $imagePath;

    public function __construct()
    {
        $this->db = new Database();
    }

    public function redirectToUserGroups()
    {

    }

    /**
     *  /index.php/user/insert
     */
    public function saveUser(): void
    {
        $this->saveUserImageToServer();
        $this->insertUserToDatabase();
        $this->saveIdentifierToSession();
    }

    private function saveUserImageToServer(): void
    {
        $fileName = RandomString::getRandomString(10);
        $fileModel = new FileModel(ServerRequestManager::filesUserImage(), $_SERVER['DOCUMENT_ROOT']."/src/public_site/media/users/$fileName");
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

    /**
     *  /index.php/user/create
     */
    public function showCreateForm(): void
    {
        echo "
            <script src='/src/public_site/js/password-validation.js' defer></script>
            <script src='/src/public_site/js/image-preview.js' defer></script
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
                    <p id='pw-validation'></p>
                    <div class='small-notice'>
                        <p>Password must be at least:</p>
                        <ul>
                            <li id='pw-length-validation'>8 characters long</li>
                        </ul>
                    </div>
                    <input type='submit' id='create-btn' name='create' class='btn' value='CREATE'>
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
        </head>
        <section>
            <article class='box login'>
                <h1>WELCOME BACK!</h1>
                <form action='' method='POST'>
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