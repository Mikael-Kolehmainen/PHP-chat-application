<?php

namespace api\model;

class MessageModel
{
    private const TABLE_NAME = 'messages';
    private const FIELD_ID = 'id';
    private const FIELD_MESSAGE = 'message';
    private const FIELD_MEDIA = 'media';
    private const FIELD_GROUPS_ID = 'groups_id';
    private const FIELD_USERS_ID = 'users_id';

    /** @var int */
    public $id;

    /** @var string */
    public $message;

    /** @var string */
    public $media;

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

    public function save(): int
    {
        return $this->db->insert(
            'INSERT INTO ' . self::TABLE_NAME .
                ' (' .
                self::FIELD_MESSAGE . ', ' .
                self::FIELD_GROUPS_ID . ', ' .
                self::FIELD_USERS_ID .
                ') VALUES (?, ?, ?)',
            [
                ['sii'],
                [
                    $this->message,
                    $this->groupsId,
                    $this->usersId,
                ]
            ]);
    }
}