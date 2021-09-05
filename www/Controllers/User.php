<?php

namespace App\Controller;

class User
{
    public function showUsersAction()
    {
        echo 'Affiche tout les utilisateurs';
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
