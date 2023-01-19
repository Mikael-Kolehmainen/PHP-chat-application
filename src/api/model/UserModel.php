<?php
namespace src\model;

class UserModel 
{
    /** @var int */
    private $id;

    /** @var string */
    private $username;

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
}