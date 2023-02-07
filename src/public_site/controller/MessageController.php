<?php

namespace public_site\controller;

use api\manager\RedirectManager;
use api\manager\ServerRequestManager;
use api\manager\SessionManager;
use api\manager\ValidationManager;
use api\model\Database;
use api\model\MessageModel;
use api\model\FileModel;

class MessageController
{
    /** @var int */
    private $id;

    /** @var string */
    private $message;

    /** @var int */
    private $groupsId;

    /** @var string */
    private $mediaPath;

    /** @var Database */
    private $db;

    public function __construct()
    {
        $this->db = new Database();
    }

    /**
     *  /index.php/message/insert
     */
    public function sendMessage()
    {
        ValidationManager::validaterUserLoggedIn();
        ValidationManager::validateGroupExistence($this->db, ServerRequestManager::getGroupIdFromUri());
        ValidationManager::validateUserGroupMembership();

        $this->groupsId = ServerRequestManager::getGroupIdFromUri();
        $this->message = ServerRequestManager::postMessage();
        $this->insertMessageToDatabase();
        RedirectManager::redirectToChat(ServerRequestManager::getGroupIdFromUri());
    }

    /**
     *  /index.php/ajax/send-media
     */
    public function sendMedia()
    {
        ValidationManager::validaterUserLoggedIn();
        ValidationManager::validateGroupExistence($this->db, ServerRequestManager::postMessageGroupId());
        ValidationManager::validateUserGroupMembership();

        $fileModel = new FileModel(
            ServerRequestManager::filesMessageImage(),
            "/src/public_site/media/chat/".ServerRequestManager::postMessageGroupId(),
            ServerRequestManager::postMessageExt()
        );
        $fileModel->generateFileName();
        $this->mediaPath = $fileModel->createFilePath();
        $fileModel->saveFileToServer();

        $this->groupsId = ServerRequestManager::postMessageGroupId();
        $this->message = "";
        $this->insertMessageToDatabase();
        RedirectManager::redirectToChat(ServerRequestManager::postMessageGroupId());
    }

    private function insertMessageToDatabase()
    {
        $messageModel = new MessageModel($this->db);
        $messageModel->message = $this->message;
        $messageModel->media = $this->mediaPath;
        $messageModel->dateOfMessage = date("Y-m-d");
        $messageModel->timeOfMessage = date("H:i");
        $messageModel->groupsId = $this->groupsId;
        $messageModel->usersId = $this->getUsersId();
        $messageModel->save();
    }

    private function getUsersId(): int
    {
        $userController = new UserController();

        return $userController->getId();
    }

    /**
     *  /index.php/ajax/get-messages/{group.id}
     */
    public function encodeDataToJSON(): void
    {
        $groupController = new GroupController();
        $groupController->id = ServerRequestManager::getGroupIdFromUri();
        $messages = $groupController->getGroupMessages();

        if (!SessionManager::issetAmountOfMessages() ||
            SessionManager::getAmountOfMessages() != count($messages)) {
            SessionManager::saveAmountOfMessages(count($messages));
            echo json_encode($groupController->getGroupMessages());
        } else {
            echo json_encode("already saved");
        }
    }

    /**
     *  /index.php/ajax/remove-messages-session
     */
    public function removeSession(): void
    {
        SessionManager::deleteAmountOfMessages();
    }
}