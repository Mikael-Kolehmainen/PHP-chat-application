<?php

namespace src\model;

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
    private $username;

    /** @var string */
    private $image;

    /** @var string */
    private $password;

    /** @var string */
    private $identifier;

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
                self::FIELD_NAME . ', ' .
                self::FIELD_IMAGE . ', ' .
                self::FIELD_PW . ', ' .
                self::FIELD_IDENTIFIER . ', ' .
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
}