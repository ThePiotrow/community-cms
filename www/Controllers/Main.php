<?php


namespace App\Controller;

use App\Core\View;

class Main
{

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
