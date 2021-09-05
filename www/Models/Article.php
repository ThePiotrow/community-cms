<?php

namespace App\Models;

use App\Core\Database;
use App\Models\User as Author;

class Article extends Database
{
    private $id = NULL;
    protected $title;
    protected $thumbnail;
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

    public function setThumbnail($thumbnail)
    {
        $this->thumbnail = $thumbnail;
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

    public function getThumbnail()
    {
        return $this->thumbnail;
    }

    public function getContent()
    {
        return $this->content;
    }

    public function getAuthor($id)
    {
        $author = new Author();
        $data = $author->selectById($id);

        $name = $data['firstname'] . " " . $data['lastname'];

        return $name;
    }

    public function getComments()
    {
        $author = new Author();
        $data = $author->selectById($id);

        $name = $data['firstname'] . " " . $data['lastname'];

        return $name;
    }

    public function addArticleFrom()
    {
        return [];
    }
}
