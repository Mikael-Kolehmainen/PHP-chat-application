<?php

namespace api\model;

class GroupModel
{
    private const TABLE_NAME = 'groups';
    private const FIELD_ID = 'id';
    private const FIELD_NAME = 'name';
    private const FIELD_IMAGE = 'image';
    private const MESSAGE_TABLE_NAME = 'messages';
    private const FIELD_GROUPS_ID = 'groups_id';

    /** @var int */
    public $id;

    /** @var string */
    public $groupName;

    /** @var string */
    public $image;

    /** @var Database */
    private $db;

    public function __construct($database)
    {
        $this->db = $database;
    }

    public function load()
    {
        $records = $this->db->select(
            'SELECT * FROM ' . self::TABLE_NAME . ' WHERE ' . self::FIELD_ID . ' = ?',
            [["s"], [$this->id]]
        );
        $record = array_pop($records);
        return $this->mapFromDbRecord($record);
    }

    public function loadGroupMessages()
    {
        $records = $this->db->select(
            'SELECT * FROM ' . self::MESSAGE_TABLE_NAME . ' WHERE ' . self::FIELD_GROUPS_ID . ' = ?',
            [["s"], [$this->id]]
        );

        $groupMessages = [];
        $i = 0;
        foreach ($records as $record) {
            $message = new MessageModel($this->db);
            $message->mapFromDbRecord($record);
            $groupMessages[$i] = $message;

            $i++;
        }

        return $groupMessages;
    }



    /**
     * @param mixed[] $record Associative array of one db record
     * @return $this
     */
    public function mapFromDbRecord($record)
    {
        $this->id = $record[self::FIELD_ID];
        $this->groupName = $record[self::FIELD_NAME];
        $this->image = $record[self::FIELD_IMAGE];

        return $this;
    }
}