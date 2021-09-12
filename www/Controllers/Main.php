<?php


namespace App\Controller;

use App\Core\Helpers;
use App\Core\View;
use App\Models\Page as PageModel;

class Main
{

    public function homeAction()
    {
        $view = new View('home');

        $Page = new PageModel();
        $pages = $Page->selectAll();

        $view->assign('pages', $pages);
    }

    //Method : Action
    public function page404Action()
    {

        //Affiche la vue 404 intégrée dans le template du front

    }
}
