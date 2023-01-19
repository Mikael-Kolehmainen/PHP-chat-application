<?php

namespace public_site\controller;

use api\manager\ServerRequestManager;
use src\model\UserModel;
use src\model\Database;

class UserController
{
    /** @var int */
    private $id;

    /** @var Database */
    private $db;

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
    public function insertUserToDatabase(): void
    {
        $userModel = new UserModel($this->db);
        $userModel->username = ServerRequestManager::postUsername();
        $this->id = $userModel->save();
    }

    /**
     *  /index.php/user/create
     */
    public function showCreateForm(): void
    {
        echo "
            <script src='/src/public_site/js/image-preview.js' defer></script
        </head>
        <section>
            <article class='box create-user'>
                <h1>WELCOME</h1>
                <form action='index.php/user/insert' method='POST'>
                    <label class='circle-file-input' id='image-file-input'>
                        <input type='file' id='image' name='user-image' accept='png/jpg/jpeg/gif' required>
                        <p id='file-input-text'>CHOOSE IMAGE</p>
                    </label>
                    <input type='text' name='username' class='input-field' maxlength='20' onkeydown='return /[a-z0-9]/i.test(event.key)' placeholder='USERNAME' required>
                    <input type='password' class='input-field' maxlength='25' onkeydown='return /[a-z0-9]/i.test(event.key)' placeholder='PASSWORD' required>
                    <input type='password' name='pw' class='input-field' maxlength='25' onkeydown='return /[a-z0-9]/i.test(event.key)' placeholder='REPEAT PASSWORD' required>
                    <div class='small-notice'>
                        <p>Password must be at least:</p>
                        <ul>
                            <li id='pw-length-validation'>8 characters long</li>
                            <li id='pw-number-letter-validation'>include numbers & letters</li>
                        </ul>
                    </div>
                    <input type='submit' name='create' class='btn' value='CREATE'>
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