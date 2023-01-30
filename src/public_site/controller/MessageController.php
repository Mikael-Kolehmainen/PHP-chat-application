<?php

namespace public_site\controller;

use api\manager\RedirectManager;
use api\manager\ServerRequestManager;
use api\model\Database;
use api\model\MessageModel;
use api\model\FileModel;

class MessageController
{
    /** @var int */
    private $id;

    /** @var string */
    private $message;

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
        $this->insertMessageToDatabase();
        RedirectManager::redirectToChat(ServerRequestManager::getGroupIdFromUri());
    }

    /**
     *  /index.php/ajax/send-media
     */
    public function sendMedia()
    {
        $fileModel = new FileModel(
            ServerRequestManager::filesMessageImage(),
            "/src/public_site/media/chat/".ServerRequestManager::postMessageGroupId(),
            ServerRequestManager::postMessageExt()
        );
        $fileModel->generateFileName();
        $this->mediaPath = $fileModel->createFilePath();
        $fileModel->saveFileToServer();

        // Inseret to database
    }

    private function insertMessageToDatabase()
    {
        $messageModel = new MessageModel($this->db);
        $messageModel->message = ServerRequestManager::postMessage();
        $messageModel->dateOfMessage = date("Y-m-d");
        $messageModel->timeOfMessage = date("H:i");
        $messageModel->groupsId = ServerRequestManager::getGroupIdFromUri();
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
    public function encodeDataToJSON()
    {
        $groupController = new GroupController();
        $groupController->id = ServerRequestManager::getGroupIdFromUri();

        echo json_encode($groupController->getGroupMessages());
    }
}