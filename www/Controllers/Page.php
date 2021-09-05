<?php

namespace App\Controller;

use App\Core\View;
use App\Core\Helpers;
use App\Models\Page as PageModel;
use App\Models\User as UserModel;

class Page
{
    public function showPagesAction()
    {
        $view = new View('front.pages');

        $Page = new PageModel();

        $pages = $Page->selectAll();

        foreach ($pages as $index => $page) {
            $pages[$index]['content'] = Helpers::troncate($page['content'], 150);
        }

        $view->assign('pages', $pages);
    }

    public function showOnePageAction($id)
    {
        $view = new View('front.page');

        $Page = new PageModel();

        $pages = $Page->selectById($id);


        if (!$pages)
            $view->assign('error', 'Page inexistante');
        else {
            $view->assign('author', $Page->getAuthor());
            $view->assign('title', $pages['title']);
            $view->assign('thumbnail', $pages['thumbnail']);
            $view->assign('content', $pages['content']);
            $view->assign('updatedAt', $pages['updatedAt']);
        }
    }

    public function updatePageAction($id)
    {
        echo 'Fiche utilisateur de ';
    }

    public function createPageAction()
    {
        if (isset($_POST)) {
        }
    }

    public function deletePageAction($id)
    {
    }
}
