<?php

namespace api\model;

class MessageModel
{
    private const TABLE_NAME = 'messages';
    private const FIELD_ID = 'id';
    private const FIELD_MESSAGE = 'message';
    private const FIELD_IMAGE = 'image';
    private const FIELD_VIDEO = 'video';
    private const FIELD_GROUPS_ID = 'groups_id';
    private const FIELD_USERS_ID = 'users_id';

    /** @var int */
    public $id;

    /** @var string */
    public $message;

    /** @var string */
    public $image;

    /** @var string */
    public $video;

    /** @var int */
    public $groupsId;

    /** @var int */
    public $usersId;

    /** @var Database */
    private $db;

    public function __construct($database)
    {
        $this->db = $database;
    }
}