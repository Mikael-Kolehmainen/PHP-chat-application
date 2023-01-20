<?php

namespace api\model;

class UserModel
{
    private const TABLE_NAME = 'users';
    private const FIELD_ID = 'id';
    private const FIELD_NAME = 'name';
    private const FIELD_IMAGE = 'image';
    private const FIELD_PW = 'pw';
    private const FIELD_IDENTIFIER = 'identifier';

    /** @var int */
    private $id;

    /** @var string */
    public $username;

    /** @var string */
    public $image;

    /** @var string */
    public $password;

    /** @var string */
    public $identifier;

    /** @var Database */
    private $db;

    public function __construct($database)
    {
        $this->db = $database;
    }

    /** @return $this */
    public function load()
    {
        $records = $this->db->select(
            'SELECT * FROM ' . self::TABLE_NAME . ' WHERE ' . self::FIELD_NAME . ' = ?',
            [["s"], [$this->username]]
        );
        $record = array_pop($records);
        return $this->mapFromDbRecord($record);
    }

    public function save(): int
    {
        return $this->db->insert(
            'INSERT INTO ' . self::TABLE_NAME .
                ' (' .
                self::FIELD_NAME . ', ' .
                self::FIELD_IMAGE . ', ' .
                self::FIELD_PW . ', ' .
                self::FIELD_IDENTIFIER .
                ') VALUES (?, ?, ?, ?)',
            [
                ['ssss'],
                [
                    $this->username,
                    $this->image,
                    $this->password,
                    $this->identifier
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
        $this->username = $record[self::FIELD_NAME];
        $this->image = $record[self::FIELD_IMAGE];
        $this->identifier = $record[self::FIELD_IDENTIFIER];
        $this->password = $record[self::FIELD_PW];

        return $this;
    }
}