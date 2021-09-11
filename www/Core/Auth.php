<?php

namespace App\Core;

use App\Core\Helpers;

use App\Models\User as UserModel;

class Auth
{
    public static function setAuth($userId)
    {
        if (session_status() == PHP_SESSION_NONE)
            session_start();

        $User = new UserModel();
        $user = $User->selectById($userId);

        if ($user)
            $_SESSION['auth'] = $userId;
    }

    public static function getConnectedUserName()
    {
        if (self::isAuth()) {

            $User = new UserModel();
            $user = $User->selectById($_SESSION['auth']);
            $User->import($user);

            return $User->getFullName();
        }
    }

    public static function isAuth()
    {
        if (session_status() == PHP_SESSION_NONE)
            session_start();

        if (isset($_SESSION['auth']))
            return 1;
        else
            return 0;
    }

    public static function endAuth()
    {
        if (session_status() == PHP_SESSION_NONE)
            session_start();

        session_destroy();
        Helpers::redirect('/');
    }
}
