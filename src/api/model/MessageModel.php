<?php

namespace api\model;

class MessageModel
{
    private const TABLE_NAME = 'messages';
    private const FIELD_ID = 'id';
    private const FIELD_MESSAGE = 'message';
    private const FIELD_MEDIA = 'media';
    private const FIELD_DATE = 'dateofmessage';
    private const FIELD_TIME = 'timeofmessage';
    private const FIELD_GROUPS_ID = 'groups_id';
    private const FIELD_USERS_ID = 'users_id';

    /** @var int */
    public $id;

    /** @var string */
    public $message;

    /** @var date(Y-m-d) */
    public $dateOfMessage;

    /** @var date(H:i) */
    public $timeOfMessage;

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

    /**
     * @param mixed[] $record Associative array of one db record
     * @return $this
     */
    public function mapFromDbRecord($record)
    {
        $this->id = $record[self::FIELD_ID];
        $this->message = $record[self::FIELD_MESSAGE];
        $this->media = $record[self::FIELD_MEDIA];
        $this->groupsId = $record[self::FIELD_GROUPS_ID];
        $this->usersId = $record[self::FIELD_USERS_ID];

        return $this;
    }
}