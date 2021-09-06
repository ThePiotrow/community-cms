<?php

namespace App\Models;

use App\Core\Database;
use App\Models\User as Author;

class Page extends Database
{
    private $id = NULL;
    protected $title;
    protected $content;
    protected $url;
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

    public function setUrl($url)
    {
        $this->url = $url;
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

    public function getUrl()
    {
        return $this->url;
    }

    public function getAuthor()
    {
        $author = new Author();
        $data = $author->selectById($this->id);

        if ($data)
            return $data['firstname'] . " " . $data['lastname'];
    }

    public function addPageForm()
    {
        return [
            "config" => [
                "method" => "POST",
                "action" => "",
                "id" => "page-create-form",
                "submit" => "Créer la page"
            ],
            "inputs" => [
                "url" => [
                    "type" => "text",
                    "label" => "URL de la page",
                    "class" => "form-input",
                    "placeholder" => "page-exemple",
                    "required" => true
                ],
                "title" => [
                    "type" => "text",
                    "label" => "Titre",
                    "class" => "form-input",
                    "required" => true
                ],
                "content" => [
                    "type" => "textarea",
                    "label" => "Contenu",
                    "class" => "form-input",
                    "required" => true
                ]
            ]
        ];
    }

    public function editPageForm($data = [])
    {
        return [
            "config" => [
                "method" => "POST",
                "action" => "",
                "id" => "page-create-form",
                "submit" => "Mettre à jour"
            ],
            "inputs" => [
                "url" => [
                    "type" => "text",
                    "label" => "URL de la page",
                    "class" => "form-input",
                    "placeholder" => "/page-exemple",
                    "required" => true,
                    "value" => $data['url'] ?? ""
                ],
                "title" => [
                    "type" => "text",
                    "label" => "Titre",
                    "class" => "form-input",
                    "required" => true,
                    "value" => $data['title'] ?? ""
                ],
                "content" => [
                    "type" => "textarea",
                    "label" => "Contenu",
                    "class" => "form-input",
                    "required" => true,
                    "value" => $data['content'] ?? ""
                ]
            ]
        ];
    }
}
