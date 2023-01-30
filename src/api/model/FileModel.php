<?php

namespace api\model;

use api\misc\RandomString;

class FileModel
{
    /** @var int */
    private $id;

    /** @var object */
    private $file;

    /** @var string */
    public $filePath;

    /** @var string */
    private $fileExt;

    public function __construct($file, $filePath, $fileExt = null)
    {
        $this->file = $file;
        $this->filePath = $filePath;
        $this->fileExt = $fileExt;
    }

    public function generateFileName(): void
    {
        $this->filePath = $this->filePath . RandomString::getRandomString(10);

        if (file_exists(($this->filePath))) {
            $this->generateFileName();
        }
    }

    public function createFilePath(): string
    {
        if ($this->fileExt === NULL) {
            $this->fileExt = pathinfo($this->file["name"], PATHINFO_EXTENSION);
        }
        $this->filePath = $this->filePath.".".$this->fileExt;

        return $this->filePath;
    }

    public function saveFileToServer(): void
    {
        move_uploaded_file($this->file["tmp_name"], $_SERVER['DOCUMENT_ROOT'].$this->filePath);
    }
}