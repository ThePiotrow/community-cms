<?php

namespace App\Models;

use App\Core\Database;

class User extends Database
{
    private $id = NULL;
    protected $firstname;
    protected $lastname;
    protected $email;
    protected $password;
    protected $verificationCode;
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

    public function setPassword($password)
    {
        $this->password = $password;
    }

    public function setStatus($status)
    {
        $this->status = $status;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getFirstname()
    {
        return ucfirst($this->firstname);
    }

    public function getLastname()
    {
        return strtoupper($this->lastname);
    }

    public function getFullName()
    {
        return $this->getFirstname() . " " . $this->getLastname();
    }

    public function getEmail()
    {
        return strtolower($this->email);
    }

    public function getPassword()
    {
        return $this->password;
    }

    public function getStatus()
    {
        return $this->status;
    }

    public function setVerificationCode()
    {
        $this->verificationCode = md5($this->getFirstname() . $this->getLastname() . $this->getEmail() . uniqid());
    }

    public function getVerificationCode()
    {
        return $this->verificationCode;
    }

    public function registrerForm()
    {
        return [
            "config" => [
                "method" => "POST",
                "action" => "/register",
                "id" => "register-form",
                "submit" => "S'inscrire"
            ],
            "inputs" => [
                "firstname" => [
                    "type" => "text",
                    "label" => "Prénom",
                    "class" => "form-input",
                    "required" => true
                ],
                "lastname" => [
                    "type" => "text",
                    "label" => "Nom",
                    "class" => "form-input",
                    "required" => true
                ],
                "email" => [
                    "type" => "email",
                    "label" => "Adresse mail",
                    "class" => "form-input",
                    "required" => true
                ],
                "password" => [
                    "type" => "password",
                    "label" => "Mot de passe",
                    "class" => "form-input",
                    "required" => true
                ]
            ]
        ];
    }

    public function loginForm()
    {
        return [
            "config" => [
                "method" => "POST",
                "action" => "/login",
                "id" => "login-form",
                "submit" => "Se connecter"
            ],
            "inputs" => [
                "email" => [
                    "type" => "email",
                    "label" => "Adresse mail",
                    "class" => "form-input",
                    "required" => true
                ],
                "password" => [
                    "type" => "password",
                    "label" => "Mot de passe",
                    "class" => "form-input",
                    "required" => true
                ]
            ]
        ];
    }

    public function updateForm($data = [])
    {
        return [
            "config" => [
                "method" => "POST",
                "action" => "",
                "id" => "update-form",
                "submit" => "Mettre à jour"
            ],
            "inputs" => [
                "firstname" => [
                    "type" => "text",
                    "label" => "Prénom",
                    "class" => "form-input",
                    "required" => true,
                    "value" => $data['firstname'] ?? ""
                ],
                "lastname" => [
                    "type" => "text",
                    "label" => "Nom",
                    "class" => "form-input",
                    "required" => true,
                    "value" => $data['lastname'] ?? ""
                ],
                "email" => [
                    "type" => "email",
                    "label" => "Adresse mail",
                    "class" => "form-input",
                    "required" => true,
                    "value" => $data['email'] ?? ""
                ],
                "password" => [
                    "type" => "password",
                    "label" => "Mot de passe",
                    "class" => "form-input",
                    "required" => true,
                    "value" => $data['password'] ?? ""
                ],
                "status" => [
                    "type" => "checkbox",
                    "label" => "Activé",
                    "class" => "form-input",
                    "value" => $data['status'] ?? ""
                ]
            ]
        ];
    }
}
