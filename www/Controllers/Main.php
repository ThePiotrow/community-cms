<?php

namespace App\Controller;

use App\Core\Database;
use App\Core\View;

class Main
{
    //Method : Action
    public function defaultAction()
    {

        $pseudo = "Prof"; // Depuis la bdd
    }

    public function homeAction()
    {
        $view = new View('front.home');
    }

    //Method : Action
    public function page404Action()
    {

        //Affiche la vue 404 intégrée dans le template du front

    }
}
