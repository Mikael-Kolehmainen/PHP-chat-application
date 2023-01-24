<?php

namespace public_site\controller;

use api\manager\SessionManager;
use api\manager\ServerRequestManager;
use api\model\Database;
use api\model\MessageModel;

class MessageController
{
    /** @var int */
    private $id;

    /** @var string */
    private $message;

    /** @var string */
    private $media;

    /** @var Database */
    private $db;

    public function __construct()
    {
        $this->db = new Database();
    }

    /**
     * index.php/message/insert
     */
    public function sendMessage()
    {
        $messageModel = new MessageModel($this->db);
        $messageModel->message = ServerRequestManager::postMessage();
        $messageModel->groupsId = ServerRequestManager::getGroupIdFromUri();
        $messageModel->usersId = $this->getUsersId();
        $messageModel->save();
    }

    private function getUsersId(): int
    {
        
    }
}