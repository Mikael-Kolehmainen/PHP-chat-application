<?php

namespace public_site\controller;

use api\manager\ServerRequestManager;
use api\manager\SessionManager;
use api\model\GroupModel;
use api\model\Database;
use api\model\FileModel;
use api\misc\RandomString;
use api\model\UserModel;

class GroupController
{
    /** @var int */
    public $id;

    /** @var string */
    private $groupName;

    /** @var string */
    private $imagePath;

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
            <title>Chat-app | Chats</title>
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
            <title>Chat-app | Create group</title>
            <script src='/src/public_site/js/file-functions.js' defer></script
        </head>
        <section>
            <article class='box create-group'>
                <h1>CREATE GROUP</h1>
                <form action='/index.php/group/insert' method='POST' enctype='multipart/form-data'>
                    <label class='circle-file-input' id='image-file-input'>
                        <input type='file' id='image' name='group-image' accept='png/jpg/jpeg/gif' required>
                        <p id='file-input-text'>CHOOSE IMAGE</p>
                    </label>
                    <input type='text' name='group-name' placeholder='GROUP NAME' class='input-field' maxlength='20'>
                    <p id='validation-msg'> </p>
                    <input type='submit' value='CREATE' class='btn' name='create-group'>
                </form>
                <a href='/index.php/groups'>Go back</a>
            </article>
        </section>
        ";
    }


    /**
     *  /index.php/group/insert
     */
    public function saveGroup()
    {
        $this->saveGroupImageToServer();
        $this->insertGroupToDatabase();
        $this->addGroupCreatorAsMemberToGroup();
        $this->redirectToGroups();
    }

    private function saveGroupImageToServer()
    {
        $fileName = RandomString::getRandomString(10);
        $fileModel = new FileModel(ServerRequestManager::filesGroupImage(), "/src/public_site/media/groups/$fileName");
        $this->imagePath = $fileModel->createFilePath();
        $fileModel->saveFileToServer();
    }

    private function insertGroupToDatabase()
    {
        $groupModel = new GroupModel($this->db);
        $groupModel->groupName = ServerRequestManager::postGroupName();
        $groupModel->image = $this->imagePath;
        $this->id = $groupModel->save();
    }

    private function addGroupCreatorAsMemberToGroup()
    {
        $userController = new UserController();
        $userController->groupsId = $this->id;
        $userController->id = $userController->getId();
        $userController->addToGroup();
    }

    private function redirectToGroups()
    {
        header("Location: /index.php/groups");
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
        $this->imagePath = $groupData->image;
    }

    private function showChatPage()
    {
        echo "
            <title>Chat-app | Chat</title>
            <script src='/src/public_site/js/ElementDisplay.js' defer></script>
            <script src='/src/public_site/js/Dropdown.js' defer></script>
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
                        <img src='$this->imagePath'>
                    </div>
                    <h1>$this->groupName</h1>

                    <div class='icon-link-container members-icon' id='members-dropdown-btn'>
                        <a href='#' class='icon-link'>
                            <i class='fa-solid fa-users'></i>
                        </a>
                    </div>
                    <div class='dropdown' id='group-members-list' style='display: none;'>
                        <ul>";
                            $this->showGroupMembers();
        echo "          </ul>
                    </div>
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
                    <input type='text' name='message' class='input-field' placeholder='Write message here' required>
                    <div class='icon-link-container camera'>
                        <a href='/index.php/group/camera/$this->id' class='icon-link'>
                            <i class='fa-solid fa-camera'></i>
                        </a>
                    </div>
                    <input type='submit' name='send-message' value='SEND' class='btn'>
                </form>
            </article>
        </section>
        ";
    }

    /*
    <li>
        <div class='round-image'>
            <img src='/src/public_site/media/placeholder.png'>
        </div>
        <p>USERNAME</p>
    </li>
    */
    private function showGroupMembers()
    {
        $groupModel = new GroupModel($this->db);
        $groupModel->id = $this->id;
        $groupMembers = $groupModel->loadGroupMembers();

        foreach ($groupMembers as $member) {
            echo "
                <li>
                    <div class='round-image'>
                        <img src='$member->image'>
                    </div>
                    <p>$member->username</p>
                </li>
            ";
        }
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
        $this->getGroupDetails();
        $this->showAddUsersPage();
    }

    private function showAddUsersPage()
    {
        echo "
            <script src='/src/public_site/js/user-search.js' defer></script>
        </head>
        <section>
            <article class='box add-users'>
                <h1>ADD USERS TO<br>$this->groupName</h1>
                <form action='/index.php/group/insert-user/$this->id' method='POST'>
                    <input type='text' placeholder='Search here (username)' id='user-search' class='search-field input-field'>
                    <ul class='list-image-title' id='user-list'>";
                        $this->showAllUsersNotInGroup();
        echo "
                    </ul>
                    <input type='submit' class='btn' value='ADD' name='group-add-user'>
                </form>
                <a href='/index.php/group/chat/$this->id'>Go back</a>
            </article>
        </section>
        ";
    }

    private function showAllUsersNotInGroup()
    {
        $userModel = new UserModel($this->db);
        $users = $userModel->loadAll();

        $groupModel = new GroupModel($this->db);
        $groupModel->id = $this->id;
        $groupMembers = $groupModel->loadGroupMembers();

        foreach ($users as $user) {
            $alreadyGroupMember = false;

            foreach ($groupMembers as $member) {
                if ($user->id == $member->id) {
                    $alreadyGroupMember = true;
                }
            }

            if (!$alreadyGroupMember) {
                echo "
                <li>
                    <div class='round-image'>
                        <img src='$user->image'>
                    </div>
                    <p>$user->username</p>
                    <input type='checkbox' name='username-checkbox-$user->id'>
                </li>
                ";
            }
        }
    }
}