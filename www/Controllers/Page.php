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
        $view = new View('front.articles');

        $Article = new PageModel();

        $articles = $Article->selectAll();

        foreach ($articles as $index => $article) {
            $articles[$index]['content'] = Helpers::troncate($article['content'], 150);
        }

        $view->assign('articles', $articles);
    }

    public function showOnePageAction($id)
    {
        $view = new View('front.article');

        $Article = new ArticleModel();

        $articles = $Article->selectById($id);


        if (!$articles)
            $view->assign('error', 'Article inexistant');
        else {
            $view->assign('author', $Article->getAuthor());
            $view->assign('title', $articles['title']);
            $view->assign('thumbnail', $articles['thumbnail']);
            $view->assign('content', $articles['content']);
            $view->assign('updatedAt', $articles['updatedAt']);
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
