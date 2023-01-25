<?php

namespace public_site\controller;

use api\manager\ServerRequestManager;
use api\model\GroupModel;
use api\model\Database;
use api\manager\SessionManager;

class GroupController
{
    /** @var int */
    public $id;

    /** @var string */
    private $groupName;

    /** @var string */
    private $image;

    /** @var Database */
    private $db;

    public function __construct()
    {
        $this->db = new Database();
    }

    /**
     *  /index.php/groups
     */
    public function showGroups()
    {
        if (SessionManager::issetUserIdentifier()) {
            $this->showGroupsPage();
        } else {
            $errorController = new ErrorController("Not logged in", "You're not logged in, please login or create an account", "/index.php/user/create");
            $errorController->showErrorPage();
        }
    }

    private function showGroupsPage()
    {
        echo "
        </head>
        <section>
            <article class='box groups'>
                <a href='/index.php/user/log-out' class='red-link'>LOGOUT</a>
                <h1>CHATS</h1>
                <ul class='list-image-title'>
        ";
                    $this->showUserGroups();
        echo "
                </ul>
                <a href='/index.php/group/create' class='btn round add'>
                    <i class='fa-solid fa-plus'></i>
                </a>
            </article>
        </section>
        ";
    }

    private function showUserGroups()
    {
        $groups = $this->getUserGroups();

        foreach ($groups as $group) {
            echo "
            <li>
                <a href='/index.php/group/chat/$group->id'>
                    <div class='round-image'>
                        <img src='$group->image'>
                    </div>
                    <p>$group->groupName</p>
                </a>
            </li>
            ";
        }
    }

    private function getUserGroups()
    {
        $userController = new UserController();
        $userController->id = $this->getUserID();;
        return $userController->getMyGroups();
    }

    private function getUserID(): int
    {
        $userController = new UserController();

        return $userController->getId();
    }

    /**
     *  /index.php/group/create
     */
    public function showCreateGroup()
    {
        echo "
            <script src='/src/public_site/js/image-preview.js' defer></script
        </head>
        <section>
            <article class='box create-group'>
                <h1>CREATE GROUP</h1>
                <form action='' method='POST' enctype='multipart/form-data'>
                    <label class='circle-file-input' id='image-file-input'>
                        <input type='file' id='image' name='group-image' accept='png/jpg/jpeg/gif' required>
                        <p id='file-input-text'>CHOOSE IMAGE</p>
                    </label>
                    <input type='text' name='groupname' placeholder='GROUP NAME' class='input-field' maxlength='20'>
                    <input type='submit' value='CREATE' class='btn'>
                </form>
                <a href='/index.php/groups'>Go back</a>
            </article>
        </section>
        ";
    }

    /**
     *  /index.php/group/chat
     */
    public function showChat()
    {
        if (SessionManager::issetUserIdentifier()) {
            if ($this->groupExists()) {
                if ($this->userIsAMember()) {
                    $this->getGroupDetails();
                    $this->showChatPage();
                } else {
                    $errorController = new ErrorController("You're not a part of the group", "You're not a part of the given group.", "/index.php/groups");
                    $errorController->showErrorPage();
                }
            } else {
                $errorController = new ErrorController("Group doesn't exist", "The group couldn't be found with the given id.", "/index.php/groups");
                $errorController->showErrorPage();
            }
        } else {
            $errorController = new ErrorController("Not logged in", "You're not logged in, please login or create an account.", "/index.php/user/create");
            $errorController->showErrorPage();
        }
    }

    private function groupExists()
    {
        $groupModel = new GroupModel($this->db);
        $groupModel->id = ServerRequestManager::getGroupIdFromUri();

        return !empty($groupModel->load()->id);
    }

    private function userIsAMember()
    {
        $groups = $this->getUserGroups();

        foreach ($groups as $group) {
            if (ServerRequestManager::getGroupIdFromUri() == $group->id) {
                return true;
            }
        }

        return false;
    }

    private function getGroupDetails()
    {
        $groupModel = new GroupModel($this->db);
        $groupModel->id = ServerRequestManager::getGroupIdFromUri();
        $groupData = $groupModel->load();

        $this->id = $groupData->id;
        $this->groupName = $groupData->groupName;
        $this->image = $groupData->image;
    }

    private function showChatPage()
    {
        echo "
            <script src='/src/api/js/remove-children.js' defer></script>
            <script src='/src/api/js/data/Data.js' defer></script>
            <script src='/src/api/js/chat/Message.js' defer></script>
            <script src='/src/api/js/chat/Chat.js' defer></script>
            <script src='/src/api/js/chat/update-chat.js' defer></script>
        </head>
        <section>
            <article class='box chat'>
                <header>
                    <div class='icon-link-container back-to-groups-icon'>
                        <a href='/index.php/groups' class='icon-link'>
                            <i class='fa-solid fa-arrow-left'></i>
                        </a>
                    </div>
                    <div class='round-image'>
                        <img src='$this->image'>
                    </div>
                    <h1>$this->groupName</h1>

                    <div class='icon-link-container add-users-icon'>
                        <a href='/index.php/group/add-user/$this->id' class='icon-link'>
                            <i class='fa-solid fa-user-plus'></i>
                        </a>
                    </div>
                </header>
                <div class='chat-view'>
                    <div class='messages' id='messages'>";

        echo "      </div>
                </div>
                <form action='/index.php/message/insert/$this->id' method='POST' class='chat-controller'>
                    <input type='text' name='message' class='input-field' placeholder='Write message here'>
                    <div class='icon-link-container camera'>
                        <a href='#' class='icon-link'>
                            <i class='fa-solid fa-camera'></i>
                        </a>
                    </div>
                    <input type='submit' name='send-message' value='SEND' class='btn'>
                </form>
            </article>
        </section>
        ";
    }

    public function getGroupMessages()
    {
        $groupModel = new GroupModel($this->db);
        $groupModel->id = $this->id;
        return $groupModel->loadGroupMessages();
    }

    /**
     *  /index.php/group/add-user
     */
    public function showAddUsers()
    {
        echo "
        </head>
        <section>
            <article class='box add-users'>
                <h1>ADD USERS TO GROUPNAME</h1>
                <form action='' method='POST'>
                    <input type='text' placeholder='Search here (username)' class='search-field input-field'>
                    <ul class='list-image-title'>
                        <li>
                            <div class='round-image'>
                                <img src='/src/public_site/media/placeholder.png'>
                            </div>
                            <p>USERNAME</p>
                            <input type='checkbox' name='username-checkbox'>
                        </li>
                        <li>
                            <div class='round-image'>
                                <img src='/src/public_site/media/placeholder.png'>
                            </div>
                            <p>USERNAME</p>
                            <input type='checkbox' name='username-checkbox'>
                        </li>
                        <li>
                            <div class='round-image'>
                                <img src='/src/public_site/media/placeholder.png'>
                            </div>
                            <p>USERNAME</p>
                            <input type='checkbox' name='username-checkbox'>
                        </li>
                        <li>
                            <div class='round-image'>
                                <img src='/src/public_site/media/placeholder.png'>
                            </div>
                            <p>USERNAME</p>
                            <input type='checkbox' name='username-checkbox'>
                        </li>
                        <li>
                            <div class='round-image'>
                                <img src='/src/public_site/media/placeholder.png'>
                            </div>
                            <p>USERNAME</p>
                            <input type='checkbox' name='username-checkbox'>
                        </li>
                    </ul>
                    <input type='submit' class='btn' value='ADD'>
                </form>
                <a href='/index.php/group/chat'>Go back</a>
            </article>
        </section>
        ";
    }
}