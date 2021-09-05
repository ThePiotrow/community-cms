<?php

namespace App\Models;

use App\Core\Database;
use App\Models\User as Author;

class Page extends Database
{
    private $id = NULL;
    protected $title;
    protected $content;
    protected $author;

    public function __construct()
    {
        parent::__construct();
    }

    public function setId($id)
    {
        $this->id = $id;
    }

    public function setTitle($title)
    {
        $this->title = $title;
    }

    public function setContent($content)
    {
        $this->content = $content;
    }

    public function setAuthor($author)
    {
        $this->author = $author;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getTitle()
    {
        return $this->title;
    }

    public function getContent()
    {
        return $this->content;
    }

    public function getAuthor()
    {
        $author = new Author();
        $data = $author->selectById($this->id);

        if ($data)
            return $data['firstname'] . " " . $data['lastname'];
    }

    public function addPageFrom()
    {
        return [];
    }

    public function editPageFrom()
    {
        return [];
    }
}
