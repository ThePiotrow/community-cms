<?php

namespace App\Models;

use App\Core\Database;

class User extends Database
{
    private $id = NULL;
    protected $firstname;
    protected $lastname;
    protected $email;
    protected $thumbnail;
    protected $password;
    protected $status;

    public function __construct()
    {
        parent::__construct();
    }

    public function setId($id)
    {
        $this->id = $id;
    }

    public function setFirstname($firstname)
    {
        $this->firstname = $firstname;
    }

    public function setLastname($lastname)
    {
        $this->lastname = $lastname;
    }

    public function setEmail($email)
    {
        $this->email = $email;
    }

    public function setThumbnail($thumbnail)
    {
        $this->thumbnail = $thumbnail;
    }

    public function setPassword($password)
    {
        $this->password = $password;
    }

    public function setStatus($status)
    {
        $this->status = $status;
    }

    public function getId($id)
    {
        return $this->id;
    }

    public function getFirstname($firstname)
    {
        return $this->firstname;
    }

    public function getLastname($lastname)
    {
        return $this->lastname;
    }

    public function getEmail($email)
    {
        return $this->email;
    }

    public function getThumbnail($thumbnail)
    {
        return $this->thumbnail;
    }

    public function getPassword($password)
    {
        return $this->password;
    }

    public function getStatus($status)
    {
        return $this->status;
    }
}
