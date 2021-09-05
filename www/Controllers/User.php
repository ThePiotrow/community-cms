<?php

namespace App\Controller;

use App\Core\View;
use App\Models\User as UserModel;

class User
{
    public function showUsersAction()
    {
        $view = new View('front.user');

        $user = new UserModel();
        $users = $user->selectAll();
    }

    public function showOneUserAction($id)
    {
        echo 'Fiche utilisateur de ' . $id;
    }

    public function updateUserAction($id)
    {
        echo 'Fiche utilisateur de ';
    }
}
