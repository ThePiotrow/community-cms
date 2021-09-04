<?php

namespace App\Models;

use App\Core\Database;

class User extends Database
{
    protected $firstname;
    protected $lastname;
    protected $email;
    protected $thumbnail;
    protected $password;
    protected $status;
}
